<div class="errormsg">
    @if ($errors->any())
        @foreach ($errors->all() as $item)
          <p>{{$item}}</p>  
        @endforeach
    @endif
  </div>

  @if (session('success'))
  <div class="layui-row">
    <div class="layui-col-sm3 successmsg">
      {{session('success')}}
    </div>
  </div>
  @endif