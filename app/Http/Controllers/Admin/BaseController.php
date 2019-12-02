<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $paginate;
    public function __construct()
    {
        $this->paginate = config('app.paginate')??10;
    }

    public function upload(Request $request)
    {
        $data = $request->only('name','config');
        
        if ($request->hasFile($data['name']) && $request->file($data['name'])->isValid()) {
            //返回文件名
            $url = $request->file($data['name'])->store('', $data['config']);
            success_info("/uploads/{$data['config']}/" . $url);
        } else {
            error_info();
        }
    }
}
