<?php

namespace App\Http\Controllers\Api;

use App\Model\Tenant;
use Illuminate\Http\Request;


class TenantController extends BaseController
{
    public function update(Request $request){
        try{
            $data = $this->validate($request,[
                'openid'=>'required',
            ]);
            $res = Tenant::where('openid',$data['openid'])->exists();
            if(!$res) throw new Exception("修改失败，缺少必要的参数");
            Tenant::where('openid',$data['openid'])->update($request->except('openid'));
        }catch(\Exception $e){
            error_info($e->getMessage().$e->getLine());
        }
        success_info();
    }

    public function edit(Request $request){
        try{
            $data = $this->validate($request,[
                'openid'=>'required',
            ]);
            $res = Tenant::where('openid',$data['openid'])->exists();
            if(!$res) throw new Exception("获取用户信息异常");
            $userinfo = Tenant::where('openid',$data['openid'])->get();
        }catch(\Exception $e){
            error_info($e->getMessage().$e->getLine());
        }
        success_info($userinfo);
    }
}
