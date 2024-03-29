@extends('admin.public.layout')
    @section('content')
    <div class="x-nav">
        <span class="layui-breadcrumb">
          <a href="">首页</a>
          <a href="">演示</a>
          <a>
            <cite>导航元素</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
          <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
      </div>
      <div class="layui-fluid">
          <div class="layui-row layui-col-space15">
              <div class="layui-col-md12">
                  <div class="layui-card">
                      <div class="layui-card-body ">
                      <form class="layui-form layui-col-space5" action="{{url('admin/role')}}" method="get">
                              <div class="layui-inline layui-show-xs-block">
                              <input type="text" name="keyword"  placeholder="请输入角色名" autocomplete="off" class="layui-input" value="{{request()->get('keyword')}}">
                              </div>
                              <div class="layui-inline layui-show-xs-block">
                                  <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                              </div>
                          </form>
                      </div>
                      <div class="layui-card-header">
                          <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                          <button class="layui-btn" onclick="xadmin.open('添加角色','{{url('admin/role/create')}}',600,400)"><i class="layui-icon"></i>添加</button>
                      </div>
                      <div class="layui-card-body ">
                          <table class="layui-table layui-form">
                            <thead>
                              <tr>
                                <th>
                                  <input type="checkbox" name=""  lay-skin="primary">
                                </th>
                                <th>ID</th>
                                <th>角色名</th>
                                <th>状态</th>
                                <th>操作</th>
                            </thead>
                            <tbody>
                              @foreach ($data as $item)
                              <tr>
                                <td>
                                  <input type="checkbox" name=""  lay-skin="primary">
                                </td>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td class="td-status">
                                  @if ($item->deleted_at)
                                  <span class="layui-btn layui-btn-danger layui-btn-mini">已禁用</span>
                                  @else
                                  <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                                  @endif
                                 </td>
                                <td class="td-manage">
                                  <a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">
                                    <i class="layui-icon">&#xe601;</i>
                                  </a>
                                  <a title="编辑"  onclick="xadmin.open('编辑','{{route('role.edit',$item)}}')" href="javascript:;">
                                    <i class="layui-icon">&#xe642;</i>
                                  </a>
                                  <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">
                                    <i class="layui-icon">&#xe640;</i>
                                  </a>
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
      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

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


</html>