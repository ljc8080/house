@extends('admin.public.layout')
@section('content')
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">租客管理</a>
            <a>
              <cite>租客列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                      <div class="layui-card-header">
                        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>

                        <button class="layui-btn" onclick="xadmin.open('添加属性','{{route('appoint.create')}}',600,600)"><i class="layui-icon"></i>添加</button>
                        
                    </div>
                        
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                    <input type="checkbox" name=""  lay-skin="primary" lay-filter="c_all" id='c_all'>
                                  </th>
                                  <th>ID</th>
                                  <th>真实名称</th>
                                  <th>昵称</th>
                                  <th>手机号</th>
                                  <th>性别</th>
                                  <th>年龄</th>
                                  <th>身份证号</th>
                                  <th>操作</th>
                              </thead>
                              <tbody class="x-cate">
                                  @foreach ($data as $item)
                                <tr >
                                  <td>
                                    <input type="checkbox" name="" lay-skin="primary" class="is_checked" lay-filter="c_one">
                                  </td>
                                  <td>{{$item->id}}</td>
                                  <td>{{$item->truename}}</td>
                                  <td>{{$item->nickname}}</td>
                                  <td>{{$item->phone}}</td>
                                  <td>{{$item->sex}}</td>
                                  <td>{{$item->age}}</td>
                                  <td>{{$item->card}}</td>
                                  
                  
                                  <td class="td-manage">
                                  
                                    {!!$item->edit('tenant.edit')!!}
                                    
                                    {!!$item->del('tenant.destroy')!!}
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            {{$data->appends(request()->except('page'))->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div> 
@endsection
 @section('js')
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });

        form.verify({
             rule: [/^\d+$/, '请选择一个规则'],
        });

        form.on('checkbox(c_all)', function (data) {
                var a = data.elem.checked;
                if (a == true) {
                    $(".is_checked").prop("checked", true);
                    form.render('checkbox');
                } else {
                    $(".is_checked").prop("checked", false);
                    form.render('checkbox');
                }
            })

            //有一个未选中全选取消选中
      form.on('checkbox(c_one)', function (data) {
            var item = $(".is_checked");
            for (var i = 0; i < item.length; i++) {
                if (item[i].checked == false) {
                    $("#c_all").prop("checked", false);
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
            $("#c_all").prop("checked", true);
            form.render('checkbox');}
        });
      });


      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });

      }

    </script>
   @endsection
