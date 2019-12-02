@extends('admin.public.layout')
@section('style')
    <style>
    </style>
@endsection
      @section('content')
      <div class="layui-fluid">
          @include('admin.public.msg')
            <div class="layui-row">
            <form class="layui-form" method="POST" action="{{route('house.store')}}">
                {{ csrf_field() }}
                @include('admin.public.msg')
                  <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源名称：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" name="house_name">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>小区名称：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" name="house_xiaoqu">
                        </div>
                    </div>
                    <div class="layui-form-item">
                            <label class="layui-form-label">房源地址</label>
                            <div class="layui-input-inline">
                              <select name="house_province" lay-filter="s">
                                <option value="">请选择省</option>
                                @foreach ($city as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="layui-input-inline">
                              <select name="house_city" lay-filter="shi"  id="shi">
                                <option value="">请选择市</option>
                              </select>
                            </div>
                            
                            <div class="layui-input-inline">
                              <select name="house_region" id="qu">
                                <option value="">请选择县/区</option>
                              </select>
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" placeholder="房源详细地址" name="house_addr">
                            </div>
                          </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源朝向：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 150px;">
                                <select name="house_direction" class="layui-input">
                                    @foreach ($attr['house_direction']['son'] as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option> 
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源面积：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <input type="text" class="layui-input" placeholder="房源面积" name="house_build_area">
                            </span>
                            <span class="layui-inline" style="width: 362px;">
                                <input type="text" class="layui-input" placeholder="使用面积" name="house_using_area">
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>建筑年代：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <input type="text" class="layui-input" placeholder="建筑年代" name="house_year">
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源租金：</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" name="house_rent">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源楼层：</label>
                        <div class="layui-input-inline">
                            
                                <input type="text" class="layui-input" placeholder="房源楼层" name="house_floor">
                            
                            <span class="layui-inline" style="width: 150px;">
                                <select name="house_shi" class="layui-input">
                                    <option value="1">一室</option>
                                    <option value="2">二室</option>
                                    <option value="3">三室</option>
                                    <option value="4">四室</option>
                                    <option value="5">五室</option>
                                    <option value="6">六室</option>
                                </select>
                            </span>
                            <span class="layui-inline" style="width: 150px;">
                                <select name="house_ting" class="layui-input">
                                    <option value="1">一厅</option>
                                    <option value="2">二厅</option>
                                    <option value="3">三厅</option>
                                    <option value="4">四厅</option>
                                    <option value="5">五厅</option>
                                    <option value="6">六厅</option>
                                </select>
                            </span>
                            <span class="layui-inline" style="width: 150px;">
                                <select name="house_wei" class="layui-input">
                                    <option value="1">一卫</option>
                                    <option value="2">二卫</option>
                                    <option value="3">三卫</option>
                                    <option value="4">四卫</option>
                                </select>
                            </span>
                            <span class="layui-inline" style="width: 150px;">
                                <select name="house_rent_class" class="layui-input">
                                    @foreach ($attr['house_rent_type']['son'] as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                    
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>配套设施：</label>
                        <div class="layui-input-block" house_config>
                            @foreach ($attr['house_config']['son'] as $item)
                        <input type="checkbox" name="house_config[]" lay-skin="primary" title="{{$item['name']}}" value="{{$item['id']}}">
                            @endforeach
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源区域：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <select name="house_area" class="layui-input">
                                    @foreach ($attr['house_area']['son'] as $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>租金范围：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <select name="house_rent_range" class="layui-input">
                                    @foreach ($attr['house_rent_range']['son'] as $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>租期方式：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <select name="house_rent_type" class="layui-input">
                                    @foreach ($attr['house_rent_type']['son'] as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源状态：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="house_status" value="0" title="待租" checked="">
                            <input type="radio" name="house_status" value="1" title="已租">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>是否推荐：</label>
                        <div class="layui-input-block">
                            <input type="radio" name="is_recommend" value="0" title="是" >
                            <input type="radio" name="is_recommend" value="1" title="否" checked='checked'>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源房东：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <select name="house_owner" class="layui-input">
                                    @foreach ($hown as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源小组：</label>
                        <div class="layui-input-inline">
                            <span class="layui-inline" style="width: 362px;">
                                <select name="house_group" class="layui-input">
                                    @foreach ($attr['house_group']['son'] as $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach  
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top:200px">
                        <label class="layui-form-label"><span class="x-red">*</span>房源摘要：</label>
                        <div class="layui-input-inline">
                            <textarea name="house_desn" class="textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item" >
                            <label for="file" class="layui-form-label">
                                   <span class="x-red">*</span>房源图片
                            </label>
                           <button type="button" class="layui-btn" id="test1">
                             <i class="layui-icon">&#xe67c;</i>上传
                           </button>
                           <img src="" alt="" width="80" id='uploadimg'>
                           <input type="hidden" name="house_pic" value="" id='pic'>
                       </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><span class="x-red">*</span>房源详情：</label>
                        <div class="layui-input-inline">
                            <textarea id="content" name="house_body"></textarea>
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
 <script src="{{template_path('admin')}}ck/ueditor.config.js"></script>
 <script src="{{template_path('admin')}}ck/ueditor.all.min.js"></script>
 <script src="{{template_path('admin')}}ck/lang/zh-cn/zh-cn.js"></script>
     <script>
          UE.getEditor('content',{initialFrameHeight:600,initialFrameWidth:800});  
     layui.use(['form', 'layer','upload'],
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
                    // console.log(123);
                    // return false;
                    // var index = parent.layer.getFrameIndex(window.name);
                    //         //关闭当前frame
                    // parent.layer.close(index);
                    // return false;
               });

               form.on('select(s)',function(data) {
                   
                   let html = "";
                    let html1 = '';
                    $.get("{{route('house.city')}}", {'pid':data.value},
                    ).then(res=>{
                        //console.log(res)
                        res.unshift({'id':'','name':"请选择市"});
                        $.each(res, function (index, value) { 
                            var cla = '';
                            if(index==0){
                               cla = 'layui-select-tips layui-this';
                            }
                             var opt = `<option value='${value.id}'>${value.name}</option>`;
                             var dd = `<dd lay-value="${value.id}" class="${cla}">${value.name}</dd>`
                             html+=dd;
                             html1+=opt;
                        });
                        $('#shi').html(html1);
                        $('#shi').next().children('dl').html(html);
                        form.render();
                    });
               });
               
            //    $('select[name="shi"').siblings("div.layui-form-select").find('dl dd[lay-value=' + data.shi + ']').click();
               //console.log($('#shi').html());
                form.on('select(shi)',function(data){
                    console.log(data)
                    let html = "";
                    let html1 = '';
                    $.get("{{route('house.city')}}", {'pid':data.value},
                    ).then(res=>{
                        //console.log(res)
                        res.unshift({'id':'','name':"请选择区"});
                        $.each(res, function (index, value) { 
                            var cla = '';
                            if(index==0){
                               cla = 'layui-select-tips layui-this';
                            }
                             var opt = `<option value='${value.id}'>${value.name}</option>`;
                             var dd = `<dd lay-value="${value.id}" class="${cla}">${value.name}</dd>`
                             html+=dd;
                             html1+=opt;
                        });
                        $('#qu').html(html1);
                        $('#qu').next().children('dl').html(html);
                        form.render();
                    });
             })
             //执行实例
          var upload = layui.upload;
          var uploadInst = upload.render({
            elem: '#test1' //绑定元素
            ,url: '{{route('admin.upload')}}' //上传接口
            ,method:'post'
            ,field:'pic'
            ,accept:'image'
            ,size:2048956
            ,multiple:true
            ,done: function(res){
               if(res.code==200){
                let val = $("#pic").val();
                  let img =  `<img src='${res.data}' style='margin-left:10px;width:80px;dispaly:inline-block'/>`
                  $("#pic").val(val+res.data+'_').after(img);
               }else{
                layer.msg('上传失败', {icon: 5});
               }
            }
            ,data:{
                'config':'house',
                'name':'pic',
                '_token':'{{csrf_token()}}'
            }
            ,error: function(){
            //请求异常回调
            layer.msg('上传失败服务器异常', {icon: 5});
            }
         });      
        });
            </script>
     @endsection