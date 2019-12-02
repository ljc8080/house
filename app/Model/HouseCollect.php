<?php

namespace App\Model;


class HouseCollect extends BaseModel
{
    public function house(){
        return $this->belongsTo(House::class,'house_id');
    }
}
