@extends('admin.public.layout')
@section('style')
    <style>
    .blue{
      color:red
    }
    .show{
      display: inline-block;
    }
    .none{
      display: none;
    }
    </style>
@endsection
@section('content')
<div class="x-nav">
  <span class="layui-breadcrumb">
    <a href="">首页</a>
    <a href="">房源</a>
    <a>
      <cite>房源列表</cite></a>
  </span>
  <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
    <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    @include('admin.public.msg')
                    <form class="layui-form layui-col-space5">
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="keyword"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                    <button class="layui-btn" onclick="xadmin.open('添加房源','{{route('house.create')}}',600,400)"><i class="layui-icon"></i>添加</button>

                </div>
                <div class="layui-card-body layui-table-body layui-table-main">
                    <table class="layui-table layui-form">
                        <thead>
                          <tr>
                            <td width="50">
                               <input type="checkbox" name=""  lay-skin="primary">
                            </td>
                            <th>ID</th>
                            <th>房源名称</th>
                            <th>房源小区名称</th>
                            <th>租聘方式</th>
                            <th>房源业主</th>
                            <th>房源租金</th>
                            <th>是否推荐</th>
                            <th>房源状态</th>
                            <th>配套设施</th>
                            <th>操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($data as $v)
                          <tr>
                            <td>
                            <input type="checkbox" name=""  value="{{$v->id}}" lay-skin="primary">
                            </td>
                            <td>{{$v->id}}</td>
                            <td>{{$v->house_name}}</td>
                            <td>{{$v->house_addr}}</td>
                            <td>{{$v->house_rent_class}}</td>
                            <td>{{$v->house_owner}}</td>
                            <td>{{$v->house_rent}}</td>
                            <td>
                              @if ($v->house_is_recommend==0)
                                  否
                              @else
                              是    
                              @endif
                            </td>
                            @if ($v->house_status==0)
                            <td>
                                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius ">待租赁</button>
                            </td>
                            @else
                            <td>
                                <button type="button" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger">已成交</button>
                            </td>
                            @endif
                            <td>{{$v->getAttrNameAttribute($v->house_config)}}</td>
                            <td class="td-manage">
                              <a title="编辑"  onclick="xadmin.open('编辑','{{route('house.edit',$v)}}',600,600)" href="javascript:;">
                                  
                                <i class="layui-icon">&#xe642;</i>
                              </a>
                              
                              <a title="删除" del-url = '{{route('house.destroy',$v)}}' onclick="member_del(this)" href="javascript:;">
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
     let _token = '{{ csrf_token() }}';
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input').prop('checked',true);
          }else{
            $('tbody input').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

    

      /*用户-删除*/
      function member_del(obj){
        let url = $(obj).attr('del-url');
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.ajax({
                type: "delete",
                url,
                data: {_token },
                dataType: "json",
              }).then(res=>{
                console.log(res)
                if(res.code==200){
                  $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg('删除失败!',{icon:5,time:1000});
                }
              });
          });
      }
      function delAll (argument) {
        var ids = [];

        // 获取选中的id 
        $('tbody input').each(function(index, el) {
            if($(this).prop('checked')){
               ids.push($(this).val())
            }
        });
        layer.confirm('确认要删除吗？',function(index){
            //捉到所有被选中的，发异步进行删除
            if(ids.length==0){
              layer.msg('请选择删除的用户', {icon: 5});
              return;
            }
            $.ajax({
              type: "delete",
              url: "{{route('manager.delall')}}",
              data: {
                ids,
                _token
              },
              //dataType: "json",
            }).then(res=>{
              console.log(res);
              layer.msg('删除成功', {icon: 1});
              $(".layui-form-checked").not('.header').parents('tr').remove();
            });         
        });
      }
      $('.card').click(function(){
        let val = $(this).next().attr('val');
        let arr =  val.split('_');
        arr.pop();
        let img = '';
        arr.map((v,i)=>{
           var src = "http://www.house.com"+v;
           var html = `<img src="${src}" width="200" style='margin-left:5px'>`;
           img+=html;
        })
        console.log(arr);

        layer.open({
          type: 1,
          skin: 'layui-layer-rim', //加上边框
          area: ['60%', '60%'], //宽高
          content: img
        });
      })

    </script>
   @endsection