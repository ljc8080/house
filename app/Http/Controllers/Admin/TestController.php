<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleCount;
use app\Tools\Es;
use GuzzleHttp\client;
use QL\QueryList;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dump(config('third.gaode'));die;
        // $client = new client(['verify'=>false]);
        // $address = request()->get('address');
        // $response = $client->request('GET',"https://restapi.amap.com/v3/geocode/geo?key=39cdd0ec0a8bb7a52f8c56334cb76755&address={$address}");
        // $res =  $response->getBody();
        // //echo $res;
        // dump(json_decode($res,true)['geocodes'][0]['location']);
        // $str = "http://www.house.com?id=%s";
        // $str1 = sprintf($str,123);
        // dd($str1);
        //     $es = new Es();
        //     $res =  $es->create_index('abc');
        //    dd($res);
        /*  $html="https://news.ke.com/bj/baike/0043/";
        $data = QueryList::Query($html,array(
            //'data指返回的键的名称'
            //array参数:
            //1.选择器  2.文本选择text  标签选择html 3.返回的节点元素去除的标签 如 -span -p 4.成功后的回调方法
            'data' => array('.tit','html','',function($item){
                return '啦啦啦'.$item;
            }) 
        ))->data;
        dump($data); */
        // $html = "https://news.ke.com/bj/baike/0043/";
        // $imglist = QueryList::Query($html, array(
        //     'img' => array('.img img', 'data-original', '', function ($item) {
        //         $client = new client(['verify' => false, 'timeout' => 5]);
        //         $response = $client->get($item);
        //         $res = $response->getBody();
        //         $path = public_path("img/" . basename($item));
        //         file_put_contents($path, $res);
        //     })
        // ))->data;
        //dump($imglist);

        // QueryList::run('Multi',[
        //     //待采集链接集合
        //     'list' => [
        //         'https://news.ke.com/bj/baike/033/pg2/',
        //         'https://news.ke.com/bj/baike/033/pg3/',
        //         'https://news.ke.com/bj/baike/033/pg4/'
        //         //更多的采集链接....
        //     ],
        //     'curl' => [
        //         'opt' => array(
        //                     //这里根据自身需求设置curl参数
        //                     CURLOPT_SSL_VERIFYPEER => false,
        //                     CURLOPT_SSL_VERIFYHOST => false,
        //                     CURLOPT_FOLLOWLOCATION => true,
        //                     CURLOPT_AUTOREFERER => true,
        //                     //........
        //                 ),
        //         //设置线程数
        //         'maxThread' => 50,
        //         //设置最大尝试数
        //         'maxTry' => 20 
        //     ],
        //     'success' => function($a){
        //         //采集规则
        //         $reg = array(
        //             //采集文章标题
        //             'title' => array('.item .tit','text'),
        //             'des' => array('.item .summary','text'),
        //             'create_time' => array('.item .time','text','',function($item){
        //                 return strtotime($item);
        //             }),
        //             //采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
        //             'content' => array('.item .tit','href')
        //             );
        //         $ql = QueryList::Query($a['content'],$reg);
        //         $data = $ql->getData();
        //         //打印结果，实际操作中这里应该做入数据库操作
        //        dump($data);
        //     }
        // ]);
            $es = new Es();
        $res = $es->search_doc('house','xiaoqu','黑马大');
        dump($res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
