<?php

namespace App\Model;

use App\Observers\HouseObserver;

class House extends BaseModel
{
    public static function boot(){
        parent::boot();
        self::observe(HouseObserver::class);
    }

    public function houseown(){
        return $this->belongsTo('App\Model\houseOwn','house_owner');
    }

    public function getAttrNameAttribute($key)
    {
        $data = HouseAttr::whereIn('id',explode(',',$key))->pluck('name','id')->toArray();
        return implode(',',$data);
    }

    public function getPicAttribute()
    {
        $img = explode('_',$this->attributes['house_pic']);
        array_pop($img);
        return $img;
    }

    public function getPicSrcAttribute(){
        return $this->attributes['house_pic'];
    }

    public function getHousePicAttribute($key){
        $imglist = explode('_',$key);
        array_pop($imglist);
        foreach ($imglist as &$v){
            $v = 'http://www.house.com'.$v;
        }
        return $imglist;
    }

    public function attr(){
        return $this->belongsTo(HouseAttr::class,'house_config');
    }
    
    public function getCreateTimeAttribute($key)
    {
        return date('Y-m-d',$key);
    }
}
