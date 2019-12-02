<?php

namespace App\Exports;

use App\Model\HouseOwn;
use Maatwebsite\Excel\Concerns\FromCollection;

class HouseOwnExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HouseOwn::all();
    }
}
