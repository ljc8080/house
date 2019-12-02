<?php
namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    use SoftDeletes;

    protected $table = "admin";
    
    public $timestamps = false;

    protected $guarded = [];

    protected $dates = ['delete_at'];

    public function setPassWordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function roles(){
        return $this->belongsTo('App\Model\Roles','role_id');
    }
}

