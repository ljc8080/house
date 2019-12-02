<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <title>租房网后台管理系统</title>
        <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="{{template_path('admin')}}lib/layui/css/layui.css" />
        <script src="{{template_path('admin')}}lib/layui/layui.js" charset="utf-8"></script>
        <link rel="stylesheet" href="{{template_path('admin')}}css/font.css">
        <link rel="stylesheet" href="{{template_path('admin')}}css/xadmin.css">
        <link rel="stylesheet" href="/css/pagination.css">
        <script type="text/javascript" src="{{template_path('admin')}}js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('style')
    </head>
    <body>
        @yield('content')
        @yield('js')
    </body>
</html>
