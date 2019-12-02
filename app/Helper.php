<?php
if(!function_exists('encryption')){
    function encryption($password){
        return md5(sha1($password.'whjfgkjwherkgjhkh2736'));
    }
}

if(!function_exists('template_path')){
    function template_path($plate){
        return "./static/{$plate}/";
    }
}

if(!function_exists('response_info')){
    function response_info($msg,$code,$data){
        return response()->json(compact('msg','code','data'))->send();
    }
}

if(!function_exists('success_info')){
    function success_info($data=[],$msg='success',$code=200){
        response_info($msg,$code,$data);
        die;
    }
}

if(!function_exists('error_info')){
    function error_info($msg='error',$code=400,$data=[]){
        response_info($msg,$code,$data);
        die;
    }
}

if (!function_exists('get_cate_list')) {
    //递归函数 实现无限级分类列表
    function get_cate_list($list, $pid = 0, $level = 0)
    {
        static $tree = array();
        foreach ($list as $row) {
            if ($row['pid'] == $pid) {
                $row['level'] = $level;
                $tree[] = $row;
                get_cate_list($list, $row['id'], $level + 1);
            }
        }
        return $tree;
    }
}

if (!function_exists('get_tree_list')) {
    //引用方式实现 父子级树状结构
    function get_tree_list($list)
    {
        //将每条数据中的id值作为其下标
        $temp = [];
        foreach ($list as $v) {
            $v['son'] = [];
            $temp[$v['id']] = $v;
        }
        //获取分类树
        foreach ($temp as $k => $v) {
            $temp[$v['pid']]['son'][] = &$temp[$v['id']];
        }
        return isset($temp[0]['son']) ? $temp[0]['son'] : [];
    }
}

function subTree(array $data, int $pid = 0){
    $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['son'] = subTree($data,$val['id']);
            if($val['alias']!=''){
                $arr[$val['alias']] = $val;
            }else{
                $arr[] = $val;
            }    
        }
    }
    return $arr;
}


