<?php

namespace App\Observers;

use App\Model\House;
use app\Tools\Es;
use GuzzleHttp\client;

class HouseObserver
{


    private $es;
    /**
     * Handle the house "created" event.
     *
     * @param  \App\Model\House  $house
     * @return void
     */

    public function __construct()
    {
        $this->es = new Es();
    }

    public function creating(House $house)
    {

        $house->house_config = implode(',', request()->get('house_config'));
        $house->create_time = time();
        $this->getLl($house);
    }

    public function created(House $house)
    {

        $this->es->add_doc($house->id, ['xiaoqu' => $house->house_xiaoqu, 'desn' => $house->house_desn], 'house', 'house');
    }


    public function updating(House $house)
    {
        if (request()->get('addr') != $house->house_addr) {
            $this->getLl($house);
        }
        $house->house_config = implode(',', request()->get('house_config'));
    }

    public function updated(House $house)
    {
        $data = ['doc' => [
            'xiaoqu' => $house->house_xiaoqu, 'desn' => $house->house_desn
        ]];
        $this->es->update_doc($house->id, 'house', 'house', $data);
    }

    /**
     * Handle the house "deleted" event.
     *
     * @param  \App\Model\House  $house
     * @return void
     */
    public function deleted(House $house)
    {
        //
    }


    private function getLl($house)
    {
        $url = config('third.gaode')['url'];
        $address = $house->house_addr;
        $url = sprintf($url, $address);
        $client = new client(['verify' => false]);
        $response = $client->request('GET', $url);
        $res =  $response->getBody();
        $location = json_decode($res, true)['geocodes'][0]['location'];
        list($longitude,$latitude) =  explode(',', $location);
        $house->latitude = $latitude;
        $house->longitude = $longitude;
    }
}
