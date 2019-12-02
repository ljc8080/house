<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HouseRequest;
use App\Model\House;
use App\Model\HouseAttr;
use App\Model\HouseOwn;
use Illuminate\Http\Request;
use DB;

class HouseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = House::with('houseown')->paginate($this->paginate);
        return view('admin/House/index',compact('data'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = $this->getcity();
        $attr = HouseAttr::all()->toArray();
        $attr =subTree($attr);
        //读取房东
        $hown = HouseOwn::pluck('name','id')->toArray();
       return view('admin/House/add',compact('city','attr','hown'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HouseRequest $request)
    {
        $data = $request->except('_token','pic');
        try{
            House::create($data);
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect(route('house.index'))->with('success','添加成功');
        
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
    public function edit(HouseRequest $houseRequest, House $house)
    {
        $sheng = $this->getcity();
        $attr = HouseAttr::all()->toArray();
        $attr =subTree($attr);
        $hown = HouseOwn::pluck('name','id')->toArray();
        $shi = $this->getcity($house->house_province);
        $qu = $this->getcity($house->house_city);
        return view('Admin/House/edit',compact('sheng','attr','hown','house','shi','qu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,House $house)
    {
        $data = $request->except('_token','_method','pic','addr');
        try{
            $house->update($data);
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->back()->with('success','添加成功');
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

    public function getcity($pid=0){
        $pid = $pid==0?request()->get('pid',0):$pid; 
        return DB::table('house_city')->where('pid',$pid)->get();
    }
}
