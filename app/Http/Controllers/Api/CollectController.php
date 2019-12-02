<?php

namespace App\Http\Controllers\Api;

use App\Model\HouseCollect;
use Illuminate\Http\Request;

class CollectController extends BaseController
{

    public function list(Request $request)
    {
        try {
            $res = $this->validate($request, [
                'openid' => 'required',
            ]);
            $data = HouseCollect::with('house')->where('openid', $res['openid'])->paginate($this->paginate);
            $msg = empty($data) ? '你暂时还没有收藏房源' : 'success';
            success_info($data, $msg);
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
    }
}
