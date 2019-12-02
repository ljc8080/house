<form class="layui-form layui-col-space5" method="POST" action="{{url('admin/rule')}}">
    {{ csrf_field() }}
    <div class="layui-inline layui-show-xs-block">
        <select name="pid" lay-verify="required|rule" id='rule' lay-filter='rule'>
          <option>请选择权限</option>
          <option value="0">顶级权限</option>
          @foreach ($data as $item)
        <option value="{{$item['id']}}">{{str_repeat('--',$item['level']*2)}}{{$item['name']}}</option>
          @endforeach
        </select>
    </div>
    <div class="layui-inline layui-show-xs-block">
        <input type="text" name="name"  autocomplete="off" placeholder="请输入名称" class="layui-input" required=''>
    </div>
    <div class="layui-inline layui-show-xs-block">
        <input type="text" name="route" autocomplete="off" placeholder="请输入路由" class="layui-input" required=''>
    </div>
    <div class="layui-inline layui-show-xs-block">
        <input type="checkbox" name="is_menu" title="是否菜单" value="1">
    </div>
    <div class="layui-inline layui-show-xs-block last">
        <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
    </div>
   @include('admin.public.msg')
</form>