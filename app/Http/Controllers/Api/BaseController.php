<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $paginate;
    public function __construct()
    {
        //$this->paginate = config('app.paginate')??10;
        $this->paginate = 10;
    }

    public function upload(Request $request)
    {
        try{
             $data = $this->validate($request,[
                'name'=>'required',
                'config'=>'required',
             ]);
        }catch(\Exception $e){
            error_info('参数缺失');
        }
        if ($request->hasFile($data['name']) && $request->file($data['name'])->isValid()) {
            //返回文件名
            $url = $request->file($data['name'])->store('', $data['config']);
            success_info("http://www.house.com/uploads/{$data['config']}/" . $url);
        } else {
            error_info();
        }
    }
}
