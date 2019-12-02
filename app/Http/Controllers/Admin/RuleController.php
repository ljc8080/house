<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Rules;
use DB;

class RuleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Rules::leftJoin('rules as r', 'rules.pid', '=', 'r.id')
                ->select('rules.*', 'r.name as pname')
                ->get();
            $data = get_cate_list($data);
            
            
        } catch (\Exception $e) {
            $data = [];
            $rules = [];
        }
        return view('admin/Rule/list', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $this->validate($request, [
            'pid' => 'required|numeric|gte:0',
            'name' => 'required|max:10|min:2',
            'route' => 'required|max:50|min:5',
            'is_menu' => 'in:1'
        ], [
            'pid.required' => '父级权限不能为空',
            'pid.numeric' => '父级权限不合法',
            'pid.gt' => '父级权限id不合法',
        ]);
        try {
            Rules::create($data);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->back()->with('success', '添加成功');
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
        try {
            $data = Rules::find($id)->toArray();
            $rules = Rules::all()->toArray(); 
            $rules = get_cate_list($rules);
            $arr = get_cate_list($rules,$data['id']);
            $rules = array_filter($rules,function($v)use($arr){
                $arr = array_column($arr,'id');
                if(!in_array($v['id'],$arr)){
                    return $v;
                }
            });
        } catch (\Exception $e) {
            $data = [];
            $rules = [];
        }
        return view('admin/Rule/edit', compact('data', 'rules'));
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
        $data =  $this->validate($request, [
            'pid' => 'required|numeric|gte:0',
            'name' => 'required|max:10|min:2',
            'route' => 'required|max:50|min:5',
            'is_menu' => 'in:1'
        ], [
            'pid.required' => '父级权限不能为空',
            'pid.numeric' => '父级权限不合法',
            'pid.gt' => '父级权限id不合法',
        ]);
        try{
            Rules::where('id',$id)->update($data);
        }catch(\Exception $e){
            error_info('未知错误',500);
        }
        success_info('修改成功');
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
