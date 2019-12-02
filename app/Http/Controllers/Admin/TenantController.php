<?php

namespace App\Http\Controllers\Admin;

use App\Model\Tenant;
use Illuminate\Http\Request;

class TenantController extends BaseController
{
    public function index(){
        $data = Tenant::paginate($this->paginate);
        return view('admin/Tenant/index',compact('data'));
    }
}
