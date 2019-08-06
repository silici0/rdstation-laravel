<?php

// Route::get('rdstation', function(){
// 	if (isset($_GET['code'])) {

// 	} else {
// 		$clientId = Config::get('rdstation.client_id');
//     	return view('rdstationview::index', ['client_id' => $clientId]);
// 	}
	
// });
Route::get('rdstation', 'silici0\RDStation\RdstationController@index');