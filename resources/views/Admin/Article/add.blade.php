@extends('admin.public.layout')
@section('content')
<style>
.layui-input-inline{
    width: 40%!important
}
</style>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" enctype="multipart/form-data">
                  <div class="layui-form-item">
                      <label for="title" class="layui-form-label">
                          <span class="x-red">*</span>文章标题
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="title" name="title" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="des" class="layui-form-label">
                          <span class="x-red">*</span>简介
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="des" name="des" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
            
                  <div class="layui-form-item">
                        <label for="category" class="layui-form-label">
                            <span class="x-red">*</span>父级分类
                        </label>
                        <div class="layui-input-inline">
                              <select name="cid" lay-verify="required" id='category' lay-filter='category'>
                                
                                <option value="0">顶级</option>    
                                @foreach ($data as $item)
                                <option value="{{$item['id']}}">{{str_repeat('--',$item['level']*2)}}{{$item['cname']}}</option>
                                @endforeach
                                </select>
                          </div>
                  </div>
                  <div class="layui-form-item" style="margin-top:200px">
                       <label for="file" class="layui-form-label">
                              <span class="x-red">*</span>请选择文章附属图片
                       </label>
                      <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传
                      </button>
                      <img src="" alt="" width="80" id='uploadimg'>
                      <input type="hidden" name="pic" value="">
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                          <span class="x-red">*</span>文章内容
                      </label>
                      <div class="layui-input-inline">
                            <textarea id="content" name="body"></textarea>    
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
 <script src="{{template_path('admin')}}ck/ueditor.config.js"></script>
 <script src="{{template_path('admin')}}ck/ueditor.all.min.js"></script>
 <script src="{{template_path('admin')}}ck/lang/zh-cn/zh-cn.js"></script>
<script>
        UE.getEditor('content',{initialFrameHeight:600});   
        layui.use(['form', 'layer','upload'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到12位'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
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
                        url: "{{route('article.store')}}",
                        data,
                        dataType: "json",
                    }).then(res=>{
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
            ,url: '{{route('admin.upload')}}' //上传接口
            ,method:'post'
            ,field:'pic'
            ,accept:'image'
            ,size:2048956
            ,done: function(res){
               if(res.code==200){
                $('#uploadimg').attr('src','http://www.house.com'+res.data).next().val(res.data)
               }else{
                layer.msg('上传失败', {icon: 5});
               }
            }
            ,data:{
                'config':'article',
                'name':'pic',
                '_token':'{{csrf_token()}}'
            }
            ,error: function(){
            //请求异常回调
            layer.msg('上传失败服务器异常', {icon: 5});
            }
   });   

  });
</script>
     @endsection
