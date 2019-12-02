<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HouseListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id'=>$this->id ,
          'house_name' =>$this->house_name,
          'house_build_area'=>$this->house_build_area,
          'house_rent'=>$this->house_rent,
          'type'=>$this->house_shi.'室'.$this->house_ting.'厅'.$this->house_wei.'卫',
          'house_pic'=>$this->house_pic,
        ];
    }
}
