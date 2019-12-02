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
                <form class="layui-form" enctype="multipart/form-data">
                  <div class="layui-form-item">
                      <label for="name" class="layui-form-label">
                          <span class="x-red">*</span>姓名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="name" name="name" required="" lay-verify="required|name"
                          autocomplete="off" class="layui-input" value="{{old('name')}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
            
                  <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>性别
                    </label>
                    <div class="layui-input-inline">
                        <input type="radio" name="sex" value="男" title="男" checked>
                        <input type="radio" name="sex" value="女" title="女">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>年龄
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="age" name="age" required="" lay-verify="required|age"
                        autocomplete="off" class="layui-input" value="{{old('age')}}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>手机
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="phone" name="phone" required="" lay-verify="required|phone"
                        autocomplete="off" class="layui-input" value="{{old('phone')}}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>身份证
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="card" name="card" required="" lay-verify="required|identity"
                    autocomplete="off" class="layui-input" value="{{old('card')}}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>家庭住址
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="address" name="address" required="" lay-verify="required"
                        autocomplete="off" class="layui-input" value="{{old('address')}}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>邮箱
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="email" name="email" required="" lay-verify="required|email"
                        autocomplete="off" class="layui-input" value="{{old('email')}}">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>

                  <div class="layui-form-item">
                       <label for="file" class="layui-form-label">
                              <span class="x-red">*</span>身份证照片
                       </label>
                      <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传
                      </button>
                      {{-- <img src="" alt="" width="80" id='uploadimg'> --}}
                      <input type="hidden" name="pic" value="">
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
        layui.use(['form', 'layer','upload'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    name: function(value) {
                        if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]{2,6}$").test(value)){
                             return '名称不能有特殊字符2-6位';
                         }
                        if(/(^\_)|(\__)|(\_+$)/.test(value)){
                          return '名称首尾不能出现下划线\'_\'';
                        }
                        if(/^\d+\d+\d$/.test(value)){
                          return '名称不能全为数字';
                        }
                    },
                    age: function(value){
                        if(value>120||value<1){
                            return '年龄不合法';
                        }
                    }
                });

                //监听提交
                form.on('submit(add)',
                function({field}) {
                    console.log(field)
                    if(field.pic==''){
                        layer.msg('请先上传图片', {icon: 5});
                        return;
                    }
                    let data = field;
                    data._token = '{{csrf_token()}}';
                    $.ajax({
                        type: "post",
                        url: "{{route('hown.store')}}",
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
                        console.log(res);
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

       var upload = layui.upload;
   
        //执行实例
        var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: '{{route('hown.upload')}}' //上传接口
            ,method:'post'
            ,field:'pic'
            ,accept:'image'
            ,multiple:true
            ,size:2048956
            ,data:{
                'config':'houseown',
                'name':'pic',
                '_token':'{{csrf_token()}}'
            }
            ,done: function(res){
                console.log(res.data)
               if(res.code==200){
                   let val = $("[type='hidden']").val();
                  let img =  `<img src='${res.data}' style='margin-left:10px;width:80px;dispaly:inline-block'/>`
                  $("[type='hidden']").val(val+res.data+'_').after(img);
               }else{
                layer.msg('上传失败', {icon: 5});
               }
            }
            ,error: function(){
            //请求异常回调
            layer.msg('上传失败服务器异常', {icon: 5});
            }
   });   

  });
</script>
     @endsection
