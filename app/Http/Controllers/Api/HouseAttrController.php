<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HouseAttr;

class HouseAttrController extends Controller
{
    public function group(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'limit' => 'numeric|min:3|max:10'
            ]);
            if (!isset($data['limit'])) $data['limit'] = 5;
            $data = HouseAttr::whereIn('pid', function ($query) {
                $query->select('id')->where('alias', 'house_group')->from('house_attr');
            })->get(['id', 'icon', 'name']);
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($data);
    }

    public function attr(Request $request){
        try{
            $this->validate($request, [
                'openid' => 'required'
            ]);
            $data = HouseAttr::all()->toArray();
            $data = get_tree_list($data);
            success_info($data);
        }catch(\Exception $e){
            error_info($e->getMessage());
        } 
    }
}
