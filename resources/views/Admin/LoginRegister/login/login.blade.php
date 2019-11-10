<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>租房后台管理系统</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{template_path('admin')}}css/font.css">
    <link rel="stylesheet" href="{{template_path('admin')}}css/login.css">
	  <link rel="stylesheet" href="{{template_path('admin')}}css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{template_path('admin')}}lib/layui/layui.js" charset="utf-8"></script>
    {{-- <script src="{{template_path('admin')}}lib/layui/sliderVerify.js" charset="utf-8"></script> --}}
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      .layui-input-block{
        margin-left: 0!important;
      }
      .loginerror p{
        color:red;
      }
    </style>
</head>
<body class="login-bg">
    <div class="login layui-anim layui-anim-up">
        <div class="loginerror">
          @if ($errors->any())
              @foreach ($errors->all() as $item)
                <p>{{$item}}</p>  
              @endforeach
          @endif
        </div>
        <div class="message">租房后台管理系统</div>
        <div id="darkbannerwrap"></div>
        
    <form method="post" class="layui-form" action="{{route('adminlogin')}}">
           {{ csrf_field() }}
            <input name="username" placeholder="用户名"  type="text" lay-verify="required|username" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required|password" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <div class="">
                <div class="layui-input-block" style="width:100%;" >
                    <div id="slider"></div>
                </div>
            </div>
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              form.verify({
              username: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                  return '用户名不能有特殊字符';
                }
                if(/(^\_)|(\__)|(\_+$)/.test(value)){
                  return '用户名首尾不能出现下划线\'_\'';
                }
                if(/^\d+\d+\d$/.test(value)){
                  return '用户名不能全为数字';
                }
              }
  
            //我们既支持上述函数式的方式，也支持下述数组的形式
            //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
          ,password: [
            /^[\S]{6,12}$/
            ,'密码必须6到12位，且不能出现空格'
          ] 
        });  
              // layer.msg('玩命卖萌中', function(){
              //   //关闭后的操作
              //   });
              //监听提交
              form.on('login', function(data){
                // alert(888)
                console.log(data)
                // layer.msg(JSON.stringify(data.field),function(){
                //    // location.href='{{url('admin/index')}}'
                // });
                return false;
              });
            });
        })


    </script>
    <script src="{{template_path('admin')}}lib/layui/sliderVerify.config.js"></script>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
</body>
</html>