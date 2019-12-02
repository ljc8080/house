@extends('admin.public.layout')
  
@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                            @foreach ($rule as $item)
                            <tr>
                                <td>
                                <input type="checkbox" lay-skin="primary" lay-filter="father" title="{{$item['name']}}" name='rules[]' value="{{$item['id']}}">
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach ($item['son'] as $v)
                                    <input name="rules[]" lay-skin="primary" type="checkbox" title="{{$v['name']}}" value="{{$v['id']}}"> 
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
              </div>
            </form>
        </div>
    </div>
    <div id="test" class="demo-tree"></div>
    @endsection
    @section('js')

    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form,
          layer = layui.layer;
        
          //自定义验证规则
          form.verify({
             name: function(value){
                if(value.length < 2||value.length>10){
                return '名称至少得2-10个字符啊';
              }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
          });

          //监听提交
          form.on('submit(add)', function(data){
            //console.log(data.field);
            //发异步，把数据提交给php
            let obj = data.field;
            obj._token = '{{csrf_token()}}'
            $.ajax({
                    type: "post",
                    url: "{{url('admin/role')}}",
                    data:obj,
                    dataType: "json",
                }).then(res=>{
                    console.log(res);
                    if(res.code==200){
                        layer.alert("增加成功", {icon: 6},function(){
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }else{
                        layer.alert("增加失败,"+res.msg, {icon: 5},function(){
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }
                }).catch(err=>{
                    console.log(err)
                    layer.alert("增加失败,"+res.msg, {icon: 5},function(){
                         var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                        parent.layer.close(index);
                    });
                })
                return false;
          });


        form.on('checkbox(father)', function(data){

            if(data.elem.checked){
                $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                form.render(); 
            }else{
               $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                form.render();  
            }
        });
  });

    </script>
 @endsection
