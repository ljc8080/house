<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    protected $table = "admin";

    public $timestamps = false;
}
