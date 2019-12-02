<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Tenant;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function login(Request $request){
        extract($request->header());

        if(!auth()->guard('api')->attempt(['username'=>$username[0],'password'=>$password[0]])){
            throw new LoginException('登陆失败');
        }
        $token = auth()->guard('api')->user()->token;
        //username+token+time+password +md5
        $str = sha1(md5($username[0].$token.$time[0].$password[0]));
        if($str!==$sign[0]){
            throw new LoginException('登陆异常');
        }
        success_info('登陆成功');
    }

    public function wxlogin(Request $request){
        $code = $request->get('code')??null;
        if(!$code) throw new LoginException('小程序登录参数异常');
        $config = config('third.wechat');
        extract($config);
        $url = sprintf($url,$appid,$secret,$code);
        try{
            $client = new Client(['verify'=>false]);
            $response = $client->request('GET',$url);
            $res = $response->getBody();
            $openid = json_decode($res,true)['openid'];
            if($openid=='none')throw new LoginException('小程序登录异常');
            $res = Tenant::where('openid',$openid)->exists();
            if(!$res){
                Tenant::insert(['openid'=>$openid]);
            }
        }catch(LoginException $e){
            error_info('小程序登陆异常');
        }
        success_info($openid);
    }

    public function update(Request $request){
        try{
            $data = $this->validate($request,[
                'openid'=>'required',
                'nickname'=>'required',
                'sex'=>'required',
                'avatar'=>'required|url',
            ]);
            $res = Tenant::where('openid',$data['openid'])->exists();
            if(!$res) throw new Exception("登录信息同步失败");
            Tenant::where('openid',$data['openid'])->update($request->except('openid'));
        }catch(\Exception $e){
            error_info($e->getMessage());
        }
        success_info();
    }
}
