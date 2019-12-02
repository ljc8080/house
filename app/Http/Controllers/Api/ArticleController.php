<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Model\Article;
use App\Model\ArticleCount;

class ArticleController extends BaseController
{
    public function list(Request $request)
    {
        try {
            $this->validate($request, [
                'page' => 'required|numeric|gt:0'
            ]);
            $data = Article::select('id', 'title', 'des', 'pic', 'create_time')->paginate($this->paginate)->toArray();
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($data);
    }

    public function read(Request $request)
    {
        try {
            $res = $this->validate($request, [
                'id' => 'required|numeric|gt:0'
            ]);
            $data = Article::where('id', $res['id'])->select('pic', 'body', 'title', 'create_time')->first();
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($data);
    }

    public function count(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'openid' => 'required',
                'id' => 'required|numeric|gt:0',
            ]);
            $model = ArticleCount::where([
                'art_id' => $data['id'],
                'openid' => $data['openid'],
            ])->first();
            if ($model) {
                $model->increment('click');
            } else {
                if (!isset($data['time'])) {
                    $data['time'] = Article::where('id', $data['id'])->value('create_time');
                }
                $data['art_id'] = $data['id'];
                ArticleCount::insert($data);
            }
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($data);
    }
}
