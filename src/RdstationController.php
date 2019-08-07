<?php

namespace silici0\RDStation;

use Illuminate\Http\Request;
use silici0\RDStation;
use App\Http\Controllers\Controller;


class RdstationController extends Controller
{
    public function index(Request $request)
    {
    	$rdstation = resolve('rdstation');
    	if ($request->input('code')) {
    		$rdstation->saveAccessToken($request->input('code'));

	    	return view('rdstationview::success');
	    } else {
	    	$clientId = Config('rdstation.client_id');
	    	return view('rdstationview::index', ['client_id' => $clientId]);
	    }
    }
}
