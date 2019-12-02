<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HouseAttr as AppHouseAttr;
use App\Model\HouseAttr;

class HouseAttrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = HouseAttr::leftJoin('house_attr as h', 'house_attr.pid', '=', 'h.id')
        ->select('house_attr.*', 'h.name as pname')
        ->get();
        $data = get_cate_list($data);
        return view('Admin/Houseattr/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = HouseAttr::select('id','pid','name')->get()->toArray();
        if(!empty($data)) $data = get_cate_list($data);
        return view('Admin/Houseattr/add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppHouseAttr $request)
    {
        $data = $request->except('_token');
        $data['create_time'] = time();
        try {
            HouseAttr::create($data);
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
