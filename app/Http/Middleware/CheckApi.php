<?php

namespace App\Http\Middleware;

use Closure;

class CheckApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        extract($request->header());
        $username = isset($username)?$username[0]:'';
        $password = isset($password)?$password[0]:'';
        $time = isset($time)?$time[0]:'';
        $sign = isset($sign)?$sign[0]:'';
        $res = auth()->guard('api')->attempt(['username'=>$username,'password'=>$password]);
        if(!$res) {
            error_info('请先登录');
        }
        $token = auth()->guard('api')->user()->token;
        $newsign = md5($username.$token.$time.$password);
        if($newsign!=$sign){
            error_info('非法请求');
        }
        return $next($request);
    }
}


