<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HouseOwnRequest;
use App\Model\HouseOwn;
use Illuminate\Http\Request;
use App\Jobs\HouseOwnExcelJob;
use Maatwebsite\Excel\Facades\Excel;

class HouseOwnController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(file_exists('./uploads/excel/houseown/hown.xlsx')){
            $style = 'show';
        }else{
            $style = 'none';
        }
        $data = HouseOwn::paginate($this->paginate);
        return view('Admin/Houseown/index',compact('data','style'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/Houseown/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HouseOwnRequest $request)
    {
        $data = $request->except('_token');
        try{
            HouseOwn::create($data);
        }catch(\Exception $e){
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

    public function excel(){
        $path = "/uploads/excel/houseown/hown.xlsx";
       // return Excel::download(new HouseOwnExport(),'hown.xlsx');
      //$obj =  Excel::store(new HouseOwnExport(), 'hown.xlsx', 'hownexcel'); //返回一个布尔值
      dispatch(new HouseOwnExcelJob());
      success_info();
    }
}
