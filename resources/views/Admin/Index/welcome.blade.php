
@extends('admin.public.layout')

 @section('style')
 
 @endsection


 @section('content')
 <div class="layui-fluid">

    <div id="main" style="width: 600px;height:400px;"></div>

 </div>
 @endsection

 @section('js')
     <script src="/js/echarts.min.js"></script>
     <script>
var dom = document.getElementById("main");
var myChart = echarts.init(dom);
option = {
    title : {
        text: '房源信息统计',
        subtext: '纯属虚构',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'right',
        data: ['已租','待租']
    },
    series : [
        {
            name: '房屋状态',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {value:{!!$data['yizu']!!}, name:'已租'},
                {value:{!!$data['weizu']!!}, name:'待租'},
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};

if (option && typeof option === "object") {
    myChart.setOption(option, true);
}
     </script>
 @endsection
