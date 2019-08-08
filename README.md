# Laravel integration for RDStation version 2.0

This library provides an objected-oriented wrapper of the PHP classes to access RDStation API v2

## Installation

```
composer require silici0/rdstation:dev-master
```

## Publish Conf File

```
php artisan vendor:publish --provider="silici0\RDStation\RDStationServiceProvider"
```

## Migration

Need to install rdstation database to store "code" and auth "key"

```
php artisan migrate
```

## Configuration

Access https://appstore.rdstation.com/pt-BR/publisher to create a new APP, on the new APP use callback url yourdomain.com/rdstation, get your ClientID and ClientSecret key, put those on config/rdstation.php

Now you can access yourdomain.com/rdstation, just access the link, give it permission, on the way back you should see a success message.

And its ready to use.

## Usage example

```
$rdstation = resolve('rdstation');

//Create or Update Lead
$d = array();
$d['name'] = 'Fulano de tal';
$d['email']= 'rafael@teste.com.br';
$d['personal_phone']='(11) 4022-1234';

$rdstation->createOrUpdate($d);

// Create new event for the Lead

$calltracking = Cookie::get('_rdtrk');
if (!empty($calltracking)) 
    $d['client_tracking_id']= $calltracking;
$utm_source = Cookie::get('__trf.src');
if (!empty($utm_source)) 
    $d['traffic_source'] = $utm_source;
else {
	// GET UTM and save in $d array
}

$rdstation->saveEvent('CONVERSION TAG NAME', $d);
```