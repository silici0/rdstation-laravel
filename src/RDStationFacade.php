<?php

namespace silici0/RDStation;

use Illuminate\Support\Facades\Facade;

class RDStationFacade extends Facade
{
	protected statis function getFacadeAccessor()
	{
		return 'laravel-rdstation';
	}
}
