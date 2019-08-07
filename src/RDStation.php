<?php

namespace silici0\RDStation;

use Carbon\Carbon;
use GuzzleHttp\Client;
use silici0\RDStation\Exceptions\ErrorControl;
use GuzzleHttp\Exception\ClientException;

class RDStation
{
	protected $rdstationModel;
	public $code;
	protected $token;

	public function __construct()
	{
		$this->rdstationModel = ModelRDStation::find(1);
		if ($this->rdstationModel != null)
		{
			$this->code = $this->rdstationModel->code;
			$this->token = $this->rdstationModel->token;
			if ($this->rdstationModel->created_at->diffInHours() >= 22)
			{
				$this->generateToken();
			}	
		}
	}

	public function returnToken()
	{
		return $this->rdstationModel->token;
	}

	protected function generateToken()
	{
		$options = [
		    'request.options' => [
		        'timeout'         => 10,
		        'connect_timeout' => 5
		    ]
		];
    	$client = new \GuzzleHttp\Client(['headers' => [
	        'Content-Type' => 'application/json'
	        ]
	    ], $options);
    	$body['client_id'] = Config('rdstation.client_id');;
		$body['client_secret'] = Config('rdstation.client_secret');
		$body['code'] = $this->code;
		$res = $client->post('https://api.rd.services/auth/token', [ 
			'body' => json_encode($body)
		]);

		$code = $res->getStatusCode();
		if ($code == '200') {
			$ret = json_decode($res->getBody()->getContents());
			$data = array();
	    	$data['client_id'] = Config('rdstation.client_id');
	    	$data['client_secret'] = Config('rdstation.client_secret');
	    	$data['code'] = $this->code;

	    	$data['token'] = $ret->access_token;
	    	$data['refresh_token'] = $ret->refresh_token;
	    	if ($this->rdstationModel == null) 
	    	{
	    		$this->rdstationModel = ModelRDStation::create($data);
	    	} else {
	    		$this->rdstationModel->update($data);
	    	}
		}
	}

	public function saveAccessToken($code)
	{
		$this->code = $code;
		$this->generateToken();
	}

	public function createOrUpdate($data)
    {
    	$this->guardAgainstAutentication();
    	$options = [
		    'request.options' => [
		        'timeout'         => 10,
		        'connect_timeout' => 5
		    ]
		];
    	$client = new \GuzzleHttp\Client(['headers' => [
    		'Authorization' => 'Bearer ' . $this->token,
	        'Content-Type' => 'application/json'
	        ]
	    ], $options);
		$url = str_replace("{value}", $data['email'], "https://api.rd.services/platform/contacts/email:{value}");
		unset($data['email']);
		try {
		    $res = $client->patch($url, [ 
				'body' => json_encode($data)
			]);
		} catch (\GuzzleHttp\Exception\ClientException $e) {
			$this->returnError($e);
		}
		$code = $res->getStatusCode();
		if ($code == '200') {
			return json_decode($res->getBody()->getContents());
		}
    }

    public function saveEvent($event_identifier, $email)
    {
    	$this->guardAgainstAutentication();
    	$options = [
		    'request.options' => [
		        'timeout'         => 10,
		        'connect_timeout' => 5
		    ]
		];
    	$client = new \GuzzleHttp\Client(['headers' => [
    		'Authorization' => 'Bearer ' . $this->token,
	        'Content-Type' => 'application/json'
	        ]
	    ], $options);
	    $body = array();
	    $body['event_type'] = "CONVERSION";
	    $body['event_family'] = "CDP";
	    $body['payload'] = array();
	    $body['payload']['conversion_identifier'] = $event_identifier;
	    $body['payload']['email'] = $email;
	    try {
		    $res = $client->post("https://api.rd.services/platform/events", [ 
				'body' => json_encode($body)
			]);
		} catch (\GuzzleHttp\Exception\ClientException $e) {
			$this->returnError($e);
		}
	    $code = $res->getStatusCode();
		if ($code == '200') {
			return json_decode($res->getBody()->getContents());
		}

    }

    protected function guardAgainstAutentication()
    {
    	if (!$this->rdstationModel) {
            throw ErrorControl::notAutenticaded();
        }
    }

    protected function returnError(\GuzzleHttp\Exception\ClientException $e)
    {
    	$response = $e->getResponse();
	    $status = $response->getStatusCode();
	    $responseBodyAsString = $response->getBody()->getContents();
	    $msg = ' Erro no envio de Lead - Status : '.$status.' - Mensagem de erro : '.$responseBodyAsString;
	    throw ErrorControl::erroMsg($msg);
    }
}