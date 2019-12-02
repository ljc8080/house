<?php

namespace App\Model;

use App\Model\Traits\Btn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes,Btn;

    public $timestamps = false;

    protected $guarded = [];

    protected $dates = ['delete_at'];

}
