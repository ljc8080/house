<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use QL\QueryList;

class ArticleContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:content';

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
        try {
            $data = DB::table('articles')->where('gather', '0')->get('url')->toArray();
            if (!$data) {
                die('没有数据');
            }
            //多线程扩展
            QueryList::run('Multi', [
                //待采集链接集合
                'list' => array_column($data,'url'),
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
                    'maxThread' => 100,
                    //设置最大尝试数
                    'maxTry' => 10
                ],
                'success' => function ($a) {
                    //采集规则
                    $reg = array(

                        'body' => array('.article-detail', 'html', '')
                    );
                    $ql = QueryList::Query($a['content'], $reg);
                    $body = $ql->getData()[0]['body']??'';
                    //打印结果，实际操作中这里应该做入数据库操作
                    $url = $a['info']['url'];
                    $gather = '1';
                    DB::table('articles')->where('url',$url)->update(compact('body','gather'));
                }
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
        echo "ok\n";
    }
}
