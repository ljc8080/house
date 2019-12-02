<?php

namespace App\Model;

class Appointment extends BaseModel
{
    // public function setCreateTimeAttribute()
    // {
    //     $this->attributes['create_time'] = time();
    // }

    public function houseown(){
        return $this->belongsTo(HouseOwn::class,'fangowner_id');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class,'renting_id');
    }

    public function getDtimeAttribute($key)
    {
        return date('Y-m-d H:i',strtotime($key));
    }
}
