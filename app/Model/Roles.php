<?php

namespace App\Model;

class Roles extends BaseModel
{
    public function rules(){
        return $this->belongsToMany('App\Model\Rules','roles&rules','role_id','rule_id');
    }
}
