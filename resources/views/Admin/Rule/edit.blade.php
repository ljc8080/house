@extends('admin.public.layout')
@section('content')
    <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>权限名称
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="name" name="name" required="" lay-verify="required"
                      autocomplete="off" class="layui-input" value="{{$data['name']}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
                  <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>路由
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="route" name="route" required="" lay-verify="required"
                            autocomplete="off" class="layui-input" value="{{$data['route']}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>
                        </div>
                   </div>
                  <div class="layui-form-item">
                        <label for="is_menu" class="layui-form-label">
                                是否菜单
                        </label>
                        <div class="layui-inline layui-show-xs-block">
                                <input type="checkbox" name="is_menu"  value="value="{{$data['is_menu']}}"" lay-skin="primary" @if ($data['is_menu']==1)
                                    checked='checked'
                                @endif>
                        </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                          <span class="x-red">*</span>父级权限
                      </label>
                      <div class="layui-inline layui-show-xs-block">
                            <select name="pid" lay-verify="required|rule" id='rule' lay-filter='rule'>
                              
                              <option value="0">顶级权限</option>    
                              @foreach ($rules as $item)
                              <option value="{{$item['id']}}">{{str_repeat('--',$item['level']*2)}}{{$item['name']}}</option>
                              @endforeach
                              </select>
                        </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="" url="{{route('rule.update',['id'=>$data['id']])}}" id="eid">
                          修改
                      </button>
                  </div>
              </form>
            </div>
    </div>
@endsection
@section('js')
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                
                form.verify({
                    rule: [/^\d+$/, '请选择一个规则'],
                });

                //监听提交
                form.on('submit(add)',
                function(d) {
                    console.log(d);
                    //发异步，把数据提交给php
                    var data = d.field;
                    data._token = '{{csrf_token()}}'
                    let url = $('#eid').attr('url');
                    console.log(url)
                    $.ajax({
                        type: "put",
                        url,
                        data,
                        dataType: "json",
                    }).then(v=>{
                        if(v.code==200){
                    layer.alert("修改成功", {icon: 6},
                    function() {
                        //关闭当前frame
                        xadmin.close();

                        // 可以对父窗口进行刷新 
                        xadmin.father_reload();
                    });
                        }else{
                    layer.alert("修改失败", {icon: 6},
                    function() {
                        //关闭当前frame
                        xadmin.close();

                        // 可以对父窗口进行刷新 
                        xadmin.father_reload();
                    });
                        }
                    });
                    
                    return false;
                });
        });
     </script>
@endsection

