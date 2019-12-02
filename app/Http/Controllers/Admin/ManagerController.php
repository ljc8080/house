<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Model\Roles;
use App\Model\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Mail;

class ManagerController extends BaseController
{
    public function list(Request $request)
    {
        $data = (new AdminService())->list($request,5);
        //if(isset($data['error'])) return redirect('admin/manager')->with('error','未知错误，请重试');
        return view('admin/Manager/list', compact('data'));
    }

    public function add(Request $request){
        $type = $request->method();
        if($type=='GET'){
            $roles = Roles::pluck('name','id');
            return view('admin/Manager/add',compact('roles'));
        }else{
            $this->validate($request,[
                'username'=>'min:3|max:15|unique:admin,username',
                'truename'=>'min:2|max:6|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
                'phone'=>'regex:/^1[3-9]\d{9}$/|unique:admin,phone',
                'email'=>'email|unique:admin,email',
                'sex'=>'in:先生,女士',
                'password'=>'regex:/^(\w){6,16}$/|confirmed',
                'role_id'=>'required'
            ],[
                'truename.regex'=>'真实名称必须是中文',
                'phone.regex'=>'手机号码格式不正确',
                'password.regex'=>'密码必须6到16位数字字母下划线',
            ]);
            $data = request()->except(['_token','like1','password_confirmation']);
            $data['create_time'] = time();
            try{
               $model = Admin::create($data);
            }catch(\Exception $e){
                return redirect()->back()->withErrors('添加失败，未知错误');
            }
            // Mail::raw('添加用户成功',function(Message $message){
            //     $message->subject('创建用户成功');
            //     $message->to('2435066598@qq.com','张三');
            // });
            Mail::send('admin.Mailer.adduser',compact('model'),function(Message $message)use($model){
                $message->subject('添加用户通知');
                $message->to('2435066598@qq.com','张三');
            });
            //dd('发送成功');
            return redirect('admin/manager')->with('success','添加成功');
        }
    }

    public function read(Request $request,$id){
        $data = Admin::find($id);
        $roles = Roles::pluck('name','id');
        if(!$data) abort(404);
        return view('admin/Manager/edit',compact('data','roles'));
    }

    public function edit(Request $request,$id){

        $this->validate($request,[
            'username'=>'min:2|max:15|unique:admin,username,'.$id,
            'truename'=>'min:2|max:6|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
            'phone'=>'regex:/^1[3-9]\d{9}$/|unique:admin,phone,'.$id,
            'email'=>'email|unique:admin,email,'.$id,
            'sex'=>'in:先生,女士',
            'password'=>'nullable|regex:/^(\w){6,16}$/|confirmed'
        ],[
            'truename.regex'=>'真实名称必须是中文',
            'phone.regex'=>'手机号码格式不正确',
            'password.regex'=>'密码必须6到16位数字字母下划线',
        ]);
        
        $data = request()->except(['_token','like1','password_confirmation','_method']);
        if($data['password']=="") unset($data['password']); 
        try{
            Admin::where('id',$id)->update($data);
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect('admin/manager')->with('success','修改成功');
    }

    public function me(Request $request){
        $type = $request->method();
        if($type=='GET'){
            return view('admin/Manager/me');
        }else{

        }
    }

    public function delete($id){
        try{
            Admin::where('id',$id)->forceDelete();
        }catch(\Exception $e){
            error_info($e->getMessage(),500);
        }
        success_info();
    }

    public function deleteAll(Request $request){
        // $ids = $request->ids;
        // $ids = $request->post('ids');
        $ids = $request->get('ids');
        try{
            Admin::destroy($ids);
        }catch(\Exception $e){
            error_info('删除失败',500);
        }
         success_info($ids);
    }

    public function recovery($id){
        try{
            Admin::withTrashed()->where('id',$id)->restore();
        }catch(\Exception $e){
            error_info('恢复失败，请重试',500);
        }
        success_info('恢复成功');
    }
}
