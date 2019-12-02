<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        //dump($params??'null');
        //dump($next);
        //dump($request);
        if(!auth()->check()){
            return redirect(route('adminlogin'))->withErrors('请先登录！');
        }
        return $next($request);
    }
}
