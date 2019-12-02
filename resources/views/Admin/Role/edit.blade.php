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
                    autocomplete="off" class="layui-input" value="{{$role->name}}">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                            @foreach ($rules as $item)
                        <tr aa="{{$item['id']}}">
                                <td>
                                <input type="checkbox" lay-skin="primary" lay-filter="father" title="{{$item['name']}}" name='rules[]' value="{{$item['id']}}"  class='c_all'>
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach ($item['son'] as $v)
                                    <input name="rules[]" lay-skin="primary" type="checkbox" title="{{$v['name']}}" value="{{$v['id']}}" lay-filter="c_one" class="is_checked"
                                    @if (in_array($v['id'],$rule))
                                        checked='checked'
                                    @endif  >  
                                    @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">修改</button>
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
                        layer.alert("修改成功", {icon: 6},function(){
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }else{
                        layer.alert("修改失败,"+res.msg, {icon: 5},function(){
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                    }
                }).catch(err=>{
                    console.log(err)
                    layer.alert("修改失败,"+res.msg, {icon: 5},function(){
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

      //有一个未选中全选取消选中
      form.on('checkbox(c_one)', function (data) {
         // console.log(data)
          let v = data.value;
          let tr = $('tr').find(`[aa=${v}]`)
          console.log(tr)
            var item = $(tr).find('.is_checked');
            console.log(item)
            for (var i = 0; i < item.length; i++) {
                if (item[i].checked == false) {
                    $(tr).find('.c_all').prop("checked", false);
                    form.render('checkbox');
                    break;
                }
            }
            //如果都勾选了  勾上全选
            var  all=item.length;
            for (var i = 0; i < item.length; i++) {
                if (item[i].checked == true) {
                    all--;
                }
            }
            if(all==0){
            $(tr).find('.c_all').prop("checked", true);
            form.render('checkbox');}
        });
  });
    </script>
 @endsection

 
