<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Index extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('checklogin');
    // }

    public function index(){
        return view('Admin/Index/index');
    }

    public function welcome(){
        return view('Admin/Index/welcome');
    }
}
