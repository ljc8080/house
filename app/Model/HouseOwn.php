<?php

namespace App\Model;

use App\Observers\HouseOwnObserver;

class HouseOwn extends BaseModel
{
    //调用观察者
    public static function boot(){
        parent::boot();
        self::observe(HouseOwnObserver::class);
    }
}
