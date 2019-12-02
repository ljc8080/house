<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Appointment;
use App\Model\Tenant;

class AppointmentController extends BaseController
{
    public function list(Request $request)
    {
        try {
            $request = $this->validate($request, [
                'openid' => 'required',
                'page' => 'required|numeric|gt:0'
            ]);
            $tenantid = Tenant::where('openid', $request['openid'])->value('id');
            if (!$tenantid) throw new Exception("error");
            $data = Appointment::with('houseown:id,name,phone')->where('renting_id', $tenantid)->paginate($this->paginate);
        } catch (\Exception $e) {
            error_info('获取信息异常');
        }
        success_info($data);
    }
}
