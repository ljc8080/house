<?php

namespace App\Model\Service;

use App\Model\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminService extends Model
{
    public function list(Request $request,$paginate=10){
        $start = $request->get('start')?strtotime($request->get('start')):null;
        $end = $request->get('end')?strtotime($request->get('end')):time();
        $keyword = $request->get('keyword');
        if($start>$end) throw new Exception("开始时间不能大于结束时间");
        try {
            return Admin::when($start,function($query)use($start,$end){
              $query->whereBetween('create_time',[$start,$end]);  
            })->when($keyword,function($query)use($keyword){
                $query->where('username','like','%'.$keyword.'%');
            })->withTrashed()->paginate($paginate);
        } catch (\Exception $e) {
            return ['error'=> $e->getMessage()];
        }
    }
}
