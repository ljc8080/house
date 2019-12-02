<?php

namespace App\Http\Controllers\Admin;

use App\Model\Roles;
use App\Model\Rules;
use DB;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Mail;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = request()->get('keyword');
        $data =  Roles::when('keyword',function($query)use($keyword){
            $query->where('name','like','%'.$keyword.'%');
        })->paginate($this->paginate);
        return view('admin/Role/index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rule = Rules::all()->toArray();
        $rule = get_tree_list($rule);
        return view('admin/Role/create',compact('rule'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'name'=>'required|min:2|max:10|unique:roles,name',
            'rules'=>'required'
        ],
        ['rules.required'=>'必须选择至少一个权限']
    );
        $data['create_time'] = time();
       DB::beginTransaction();
        try{
           $roles = Roles::create($request->only('name'));
           $roles->rules()->sync($data['rules']);
        }catch(\Exception $e){
            DB::rollBack();
            error_info($e->getMessage().'--'.$e->getCode().'--'.$e->getFile());
        }
        DB::commit();
        // Mail::raw('哈哈哈',function(Message $message){
        //     $message->subject('创建角色成功');
        //     $message->to('2435066598@qq.com','李四');
        // });
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
    public function edit(Roles $role) 
    {
        try{
            $rules = Rules::all()->toArray();
            $rules = get_tree_list($rules);
            $rule = $role->rules()->pluck('rules.id')->toArray();
        }catch(\Exception $e){
            dd($e->getMessage());
        }
        return view('admin/Role/edit',compact('rules','role','rule'));
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

    }
}
