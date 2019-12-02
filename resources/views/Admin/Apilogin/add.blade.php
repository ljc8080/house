@extends('admin.public.layout')
@section('style')
<style>
        .layui-input-inline{
            width: 40%!important
        }
 </style>
@endsection
@section('content')

        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                  <div class="layui-form-item">
                      <label for="name" class="layui-form-label">
                          <span class="x-red">*</span>账号
                      </label>
                      
                            <div class="layui-input-inline">
                              <input type="text" class="layui-input" lay-verify="required" name="username">
                            </div>
                    
                  </div>

                  <div class="layui-form-item">
                        <label for="password" class="layui-form-label">
                            <span class="x-red">*</span>密码
                        </label>
                        <div class="layui-input-inline">
                            <input type="password" name="password"  
                            autocomplete="off" class="layui-input" lay-verify="required">
                        </div>
                    </div>

                    <div class="layui-form-item">
                            <label for="token" class="layui-form-label">
                                <span class="x-red">*</span>token
                            </label>
                            <div class="layui-input-inline">
                                <input type="text" name="token"  
                                autocomplete="off" class="layui-input" lay-verify="required">
                            </div>
                     </div>
                   
                     <div class="layui-form-item">
                            <label for="click" class="layui-form-label">
                                <span class="x-red">*</span>请求次数
                            </label>
                            <div class="layui-input-inline">
                                <input type="text" name="click"  
                                autocomplete="off" class="layui-input" lay-verify="required">
                            </div>
                    </div>
                  
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          增加
                      </button>
                  </div>
              </form>
            </div>
        </div>
 @endsection
 @section('js')
<script>  
        layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;


                //自定义验证规则
                form.verify({
                    alias: function(value) {
                        let val = $('#category').val();
                        if(val==0){
                            return '请填写别名';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到12位'],
                });

                //监听提交
                form.on('submit(add)',
                function({field}) {
                    console.log(field)
                    let data = field;
                    data._token = '{{csrf_token()}}';
                    $.ajax({
                        type: "post",
                        url: "{{route('apilogin.store')}}",
                        data,
                        dataType: "json",
                    }).then(res=>{
                        console.log(res)
                        if(res.code==200){
                            layer.alert("增加成功", {
                                icon: 6
                            },()=>{
                                //关闭当前frame
                                  xadmin.close();
                                // 可以对父窗口进行刷新 
                                 xadmin.father_reload();
                            })
                        }else{
                            
                        }
                    }).catch(res=>{
                        console.log(res)
                        layer.msg('添加失败', {icon: 5},()=>{
                                //关闭当前frame
                                xadmin.close();
                                // 可以对父窗口进行刷新 
                                xadmin.father_reload();
                            });
                    })
                    //发异步，把数据提交给php
                    return false;
                }); 

  });
</script>
     @endsection
