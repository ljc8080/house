<?php

namespace App\Console\Commands;

use App\Model\Article;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use QL\QueryList;

class Spider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        QueryList::run('Multi', [
            //待采集链接集合
            'list' => [
                'https://news.ke.com/bj/baike/033/pg2/',
                'https://news.ke.com/bj/baike/033/pg3/',
                'https://news.ke.com/bj/baike/033/pg4/'
                //更多的采集链接....
            ],
            'curl' => [
                'opt' => array(
                    //这里根据自身需求设置curl参数
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                    //........
                ),
                //设置线程数
                'maxThread' => 50,
                //设置最大尝试数
                'maxTry' => 20
            ],
            'success' => function ($a) {
                //采集规则
                $reg = array(
                    //采集文章标题
                    'title' => array('.item .tit', 'text'),
                    'des' => array('.item .summary', 'text'),
                    'pic' => array('.item .img img', 'data-original', '', function ($item) {
                        $client = new Client(['verify' => false, 'timeout' => 5]);
                        $response = $client->get($item);
                        $file = $response->getBody();
                        $path = public_path('uploads/article/' . basename($item));
                        file_put_contents($path,$file);
                        return basename($item);
                    }),
                    'create_time' => array('.item .time', 'text', '', function ($item) {
                        return strtotime($item);
                    }),
                    //采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
                    'url' => array('.item .tit', 'href')
                );
                $ql = QueryList::Query($a['content'], $reg);
                $data = $ql->getData();
                //打印结果，实际操作中这里应该做入数据库操作
                try {
                    foreach ($data as $item) {
                        $item['cid'] = mt_rand(2, 5);
                        $item['body'] = '';
                        Article::create($item);
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                echo "ok\n";
            }
        ]);
    }
}
