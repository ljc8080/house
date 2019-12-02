<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\House;
use App\Model\Rules;

class IndexController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        if ($user->username == 'admin') {
            $rules = Rules::where('is_menu', '1')->get()->toArray();
        } else {
            $rules = $user->roles->rules()->where('is_menu', '1')->get()->toArray();
        }
        if (count($rules) > 1) {
            $rules = get_tree_list($rules);
        };
        return view('admin/Index/index', compact('rules'));
    }

    public function welcome()
    {
        $data = [];
        $data['yizu'] = House::where('house_status', '1')->count();
        $data['weizu'] = House::where('house_status', '0')->count();
        return view('admin/Index/welcome', compact('data'));
    }
}
