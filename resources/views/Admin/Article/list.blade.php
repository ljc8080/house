@extends('admin.public.layout')
@section('style')
    <style>
    .center{
      text-align: center!important
    }
    </style>
@endsection
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
                    <form class="layui-form layui-col-space5">
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="title"  placeholder="请输入文章标题" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn"  lay-filter="sreach"  id='search'><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                    <button class="layui-btn" onclick="xadmin.open('添加文章','{{route('article.create')}}',600,600)"><i class="layui-icon"></i>添加</button>
                </div>
                <div class="layui-card-body ">
                    <table class="layui-table layui-form table-sort">
                      <thead>
                        <tr>
                          <th class="center">
                            <input type="checkbox" name=""  lay-skin="primary" >
                          </th>
                          <th class="center">ID</th>
                          <th class="center">所属类别</th>
                          <th class="center">标题</th>
                          <th class="center">创建时间</th>
                          <th class="center">操作</th>
                        </tr> 
                      </thead>
                      <tbody  class="center">
                        
                       {{--  @foreach ($data as $item)
                        <tr>
                          <td>
                            <input type="checkbox" name=""  lay-skin="primary">
                          </td>
                          <td>{{$item->id}}</td>
                          <td>{{$item->cate->cname}}</td>
                          <td>{{$item->title}}</td>
                          <td>{{$item->create_time}}</td>
                          <td class="td-manage">
                            <a  href="javascript:;"  title="启用">
                              <i class="layui-icon">&#xe601;</i>
                            </a>
                            <a title="编辑" >
                              <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除">
                              <i class="layui-icon" class="del">&#xe640;</i>
                            </a>
                          </td>
                        </tr>
                        @endforeach --}}
                      </tbody>
                    </table>
                </div>
                <div class="layui-card-body ">
                   
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection

@section('js')
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
  $(function(){
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



     const dataTable =  $('.table-sort').dataTable({
        //表格的第几列排序，desc/asc
        order: [[ {{request()->get('order')[0]['column']??1}}, "{{request()->get('order')[0]['dir']??'desc' }}" ]],
        //表格第几列不进行排序
        columnDefs:[
          //注意列数
         {targets:[0,5],orderable:false}
        ],
        lengthMenu: [ 10, 25, 50, 75, 100 ],
        // 取消默认搜索
        searching: false,
        //开启服务器模式
        serverSide: true,
        //从第几页开始分页，动态获取
        displayStart:{{request()->get('start')??0}},

        //发送ajax
        ajax: {
            // 请求地址
            url: '{{route('article.index')}}',
            // 请求方式 get/post
            type: 'get',
            // 头信信息 laravel post请求时 csrf
            //headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            data:function(v){
              v.keyword=$('[name=title]').val();
              v.starttime=$('#start').val();
              v.end=$('#end').val();
            }
         },
         //该选项操作ajax返回后表格的数据显示，需定义每列的数据
         columns: [
            // 总的数量与表格的列的数量一致，不多也不少
            // 字段名称与sql查询出来的字段时尽量要保持一致，就是服务器返回数据对应的字段名称
            // defaultContent 和 className 可选参数
            {'data':'checkbox'},
            {'data':'id'},
            {'data':'cate.cname'},
            {'data':'title'},
            {'data':'create_time'},
             //动态的显示rbac按钮需要在模型添加自定义属性
            {'data':'btn'},
            //如果列的字段和数据库字段不一致,需要自定义个占位，并且要给defaultContent默认值

        ],
        //返回每一行的数据和当前行的dom对象
        createdRow:function(row,data){
         
         /*  console.log(row);
          console.log(data);
          var checkbox = `<input type="checkbox" name="article[]"  lay-skin="primary" value="${data.id}">`;
          $(row).find('td:first-child').html(checkbox);
          $(row).find('td:last-child').html(data.btn); */
        }
      })
      //搜索时重新调用ajax方法发送数据
      $('#search').click(function(){
        dataTable.api().ajax.reload();
      })
     
      $('tbody').on('click','.del',function(){
        layer.confirm('您确定要删除吗？', {
          btn: ['是','否'] //按钮
       },(index)=>{
            let url = $(this).attr('href');
            fetch(url,{
              method:'delete',
              headers:{
                'X-CSRF-TOKEN' : '{{ csrf_token() }}',
                'content-type' : 'application/json'
              },
            }).then(res=>{
              console.log(res);
              return res.json()
            }).then(res=>{
              console.log(res)
              if(res.code==200){
                layer.msg('删除成功');
              }else{
                layer.msg('删除失败');
              }
            })
            layer.close(index);
          })
       })
  })
  

</script>
@endsection