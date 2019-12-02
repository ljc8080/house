<?php

namespace app\Model\Traits;

trait Btn
{

    private function check($route)
    {
        $rules = request()->rules;
        if(!request()->has('user')){return false;}
        if (request()->user == 'admin') {
            return true;
        } else {
            if (in_array($route, $rules)) {
                return  true;
            } else {
                return false;
            }
        }
    }


    public function edit($route)
    {
        $url = route($route, ['id' => $this->id]);
        $url = $url . '?' . http_build_query(request()->all());
        $str = <<<"button"
        <button class="layui-btn layui-btn layui-btn-xs"  onclick="xadmin.open('编辑','$url')" ><i class="layui-icon">&#xe642;</i>编辑</button>        
button;
        if ($this->check($route)) {
            return $str;
        } else {
            return '';
        }
    }

    public function del($route)
    {
        $href = route($route, ['id' => $this->id]);
        $str = <<<"button"
        <button class="layui-btn-danger layui-btn layui-btn-xs del" href="$href" ><i class="layui-icon">&#xe640;</i>删除</button>
button;
        if ($this->check($route)) {
            return $str;
        } else {
            return '';
        }
    }
}
