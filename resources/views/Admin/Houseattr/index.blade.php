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
                      <div class="layui-card-header">
                        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>

                        <button class="layui-btn" onclick="xadmin.open('添加属性','{{route('hattr.create')}}',600,600)"><i class="layui-icon"></i>添加</button>
                        
                    </div>
                        
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                    <input type="checkbox" name=""  lay-skin="primary" lay-filter="c_all" id='c_all'>
                                  </th>
                                  <th>ID</th>
                                  <th>名称</th>
                                  <th>父级属性</th>
                                  <th>操作</th>
                              </thead>
                              <tbody class="x-cate">
                                  @foreach ($data as $item)
                                <tr cate-id='{{$item['id']}}' fid='{{$item['pid']}}' >
                                  <td>
                                    <input type="checkbox" name="" lay-skin="primary" class="is_checked" lay-filter="c_one">
                                  </td>
                                  <td>{{$item['id']}}</td>
                                  <td>
                                      <i class="layui-icon x-show" status='true'>&#xe623;</i>
                                      {{$item['name']}}
                                    </td>
                                    <td>
                                        <i class="layui-icon x-show" status='true'>&#xe623;</i>
                                        {{$item['pname']??'顶级'}}
                                      </td>
                
                                      @if ($item['id']==1)
                                          
                                      @endif
                                  <td class="td-manage">
                                  {{-- <button class="layui-btn layui-btn layui-btn-xs"  onclick="xadmin.open('编辑','{{route('rule.edit',$item)}}')" ><i class="layui-icon">&#xe642;</i>编辑</button> --}}
                                    {!!$item->edit('hattr.edit')!!}
                                    {{-- <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'要删除的id')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button> --}}
                                    {!!$item->del('hattr.destroy')!!}
                                  </td>
                                </tr>
                                @endforeach
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
      $(function(){
            $("tbody.x-cate tr[fid!='0']").hide();
            // 栏目多级显示效果
            $('.x-show').click(function () {
                if($(this).attr('status')=='true'){
                    $(this).html('&#xe625;'); 
                    $(this).attr('status','false');
                    cateId = $(this).parents('tr').attr('cate-id');
                    $("tbody tr[fid="+cateId+"]").show();
               }else{
                    cateIds = [];
                    $(this).html('&#xe623;');
                    $(this).attr('status','true');
                    cateId = $(this).parents('tr').attr('cate-id');
                    getCateId(cateId);
                    for (var i in cateIds) {
                        $("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.x-show').html('&#xe623;').attr('status','true');
                    }
               }
            })
          })

          var cateIds = [];
          function getCateId(cateId) {
              $("tbody tr[fid="+cateId+"]").each(function(index, el) {
                  id = $(el).attr('cate-id');
                  cateIds.push(id);
                  getCateId(id);
              });
          }

    </script>
   @endsection
