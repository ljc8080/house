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
                          <span class="x-red">*</span>属性名称
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="name" name="name" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>

                  <div class="layui-form-item">
                        <label for="alias" class="layui-form-label">
                            <span class="x-red">*</span>属性别名
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="alias" name="alias"  lay-verify="alias"
                            autocomplete="off" class="layui-input">
                        </div>
                    </div>

                  <div class="layui-form-item">
                        <label for="category" class="layui-form-label">
                            <span class="x-red">*</span>父级分类
                        </label>
                        <div class="layui-input-inline">
                              <select name="pid" lay-verify="required" id='category' lay-filter='category'> 
                                <option value="0">顶级</option>    
                                @foreach ($data as $item)
                                <option value="{{$item['id']}}">{{str_repeat('--',$item['level']*2)}}{{$item['name']}}</option>
                                @endforeach
                                </select>
                          </div>
                  </div>
                  <div class="layui-form-item">
                       <label for="file" class="layui-form-label">
                              <span class="x-red">*</span>请选择文章附属图片
                       </label>
                      <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传
                      </button>
                      <img src="" alt="" width="80" id='uploadimg'>
                      <input type="hidden" name="icon" value="">
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
                    if(field.pic==''){
                        layer.msg('请先上传图片', {icon: 5});
                        return;
                    }
                    let data = field;
                    data._token = '{{csrf_token()}}';
                    $.ajax({
                        type: "post",
                        url: "{{route('hattr.store')}}",
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
            ,url: '{{route('article.upload')}}' //上传接口
            ,method:'post'
            ,field:'icon'
            ,accept:'image'
            ,size:2048956
            ,data:{
                'config':'houseattr',
                'name':'icon',
                '_token':'{{csrf_token()}}'
            }
            ,done: function(res){
                console.log(res.data)
               if(res.code==200){
                $('#uploadimg').attr('src','http://www.house.com'+res.data).next().val(res.data)
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
