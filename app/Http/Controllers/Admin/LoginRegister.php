<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginRegister extends Controller
{
    public function login(Request $request){
        $type = $request->method();
        if($type=='GET'){
            return view('Admin/LoginRegister/login/login');
        }else{
            $data = $this->validate($request,[
                'username'=>'required|max:10|min:1',
                'password'=> 'required|regex:/^[\S]{6,12}$/'
            ],[
                'password.regex'=>'密码长度6-15位不能有空格'
            ]);

            //guard参数在配置文件中查看，默认是web省略此方法
            $res = auth()->guard('web')->attempt($data);
            //auth()->user();
            if(!$res){
                return redirect()->back()->withErrors('用户名或密码错误');
            }else{
                return redirect('admin/index');
            }
        }
    }
}
