<?php

namespace App\Observers;

use App\Jobs\HouseOwnJob;
use App\Model\HouseOwn;


class HouseOwnObserver
{
    /**
     * Handle the house own "created" event.
     *
     * @param  \App\Model\HouseOwn  $houseOwn
     * @return void
     */

    public function creating(HouseOwn $houseOwn)
    {
        //$houseOwn是模型对象
        $houseOwn->create_time = time();
    }

    public function created(HouseOwn $houseOwn)
    {
        //投递任务
        //把模型对象信息传递过去
        dispatch(new HouseOwnJob($houseOwn));
        
    }
}
