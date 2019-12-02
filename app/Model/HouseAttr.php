<?php

namespace App\Model;

class HouseAttr extends BaseModel
{
    protected $table = 'house_attr';

    public function getIconAttribute($key)
    {
        $url = "http://www.house.com";
        if(!substr_count($key,$url)&&!empty($key)){
            return $url.$key;
        }
        return $key;
    }
}
