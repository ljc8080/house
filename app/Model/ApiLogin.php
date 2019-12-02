<?php

namespace App\Model;

use App\User;

class ApiLogin extends User
{
    protected $table = 'api_login';

    public $timestamps = false;

    protected $guarded = [];

    /* public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
        //$this->attributes['visiblepass'] = $value;
    } */
}
