<?php

namespace silici0\RDStation;

use Illuminate\Database\Eloquent\Model;

class ModelRDStation extends Model
{
    protected $table = 'rdstations';

    protected $fillable = [
        'client_id', 'client_secret', 'code', 'token', 'refresh_token'
    ];
}