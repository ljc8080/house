@extends('admin.public.layout')
      @section('content')
      <div class="layui-fluid">
          @include('admin.public.msg')
            <div class="layui-row">
            <form class="layui-form" method="POST" action="{{route('manageradd')}}">
                {{ csrf_field() }}
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>登录名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="username" required="" lay-verify="required"
                      autocomplete="off" class="layui-input" value="{{old('username')}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
                  <div class="layui-form-item">
                        <label for="truename" class="layui-form-label">
                            <span class="x-red">*</span>真实姓名
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="truename" name="truename" required="" lay-verify="required"
                            autocomplete="off" class="layui-input" value="{{old('truename')}}">
                        </div>
                        <div class="layui-form-mid layui-word-aux">
                            {{-- <span class="x-red">*</span>将会成为您唯一的登入名 --}}
                        </div>
                    </div>
                  <div class="layui-form-item">
                      <label for="phone" class="layui-form-label">
                          <span class="x-red">*</span>手机
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="phone" name="phone" required="" lay-verify="phone"
                          autocomplete="off" class="layui-input" value="{{old('phone')}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>邮箱
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="L_email" name="email" required="" lay-verify="email"
                          autocomplete="off" class="layui-input" value="{{old('email')}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          {{-- <span class="x-red">*</span> --}}
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label"><span class="x-red">*</span>角色</label>
                      <div class="layui-input-block">
                          @foreach ($roles as $key => $item)
                          <input type="radio" name="role_id" value="{{$key}}" title="{{$item}}" required=''>
                          @endforeach
                        
                      </div>
                  </div>
                  <div class="layui-form-item">
                        <label class="layui-form-label">性别</label>
                        <div class="layui-input-block">
                          <input type="radio" name="sex" value="先生" title="先生" checked="checked">
                          <input type="radio" name="sex" value="女士" title="女士">
                        </div>
                      </div>
                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                          <span class="x-red">*</span>密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                          autocomplete="off" class="layui-input" value="{{old('password')}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          6到16个字符
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                          <span class="x-red">*</span>确认密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_repass" name="password_confirmation" required="" lay-verify="repass"
                          autocomplete="off" class="layui-input" value="{{old('password_confirmation')}}">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          增加
                      </button>
                  </div>
              </form>
            </div>
        </div>
      @endsection
     @section('js')
     <script>
     layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    username: function(value) {
                        if (value.length < 2) {
                            return '昵称至少得2个字符啊';
                        }else if(value.length>15){
                            return '昵称要小于15个字符啊';
                        }
                    },
                    pass: [/^(\w){6,16}$/, '密码必须6到16位数字字母下划线'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
                        }
                    }
                });

                //监听提交
                form.on('submit(add)',function(data) {
                    // var index = parent.layer.getFrameIndex(window.name);
                    //         //关闭当前frame
                    // parent.layer.close(index);
                    // return false;
               });

            });</script>
     @endsection