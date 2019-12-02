<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $allow = ['admin','adminlogin','adminlogout','admin.welcome','managerme'];

    public function handle($request, Closure $next)
    {
        $user = auth()->user();  //获取用户信息，得到用户模型
        //调用模型关联又获得了一个关联的模型对象
        $rules = $user->roles->rules()->pluck('route','rules.id')->toArray();
        //dd($roles);
        //dd(auth()->user()->roles()->first());
        $route = $request->route()->getName();
        $request->rules = $rules;
        $request->user = $user->username; 
        if($user->username!='admin'&&!in_array($route,$rules)&&!in_array($route,$this->allow)){
           die('你没有足够的权限访问'); 
        }
//         第1点：在trait中使用了$this，此时的$this就是调用者的模型对象
//          第2点：路由别名是通过前端传过来的
//          第3点：{{}}默认是进行html转义，所以用 {!! !!} 来让blade不转义html

        return $next($request);
    }
}
