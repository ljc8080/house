<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleAdd;
use App\Model\Article;
use App\Model\Category;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /* draw: 客户端调用服务器端次数标识
        ecordsTotal: 获取数据记录总条数
        ecordsFiltered: 数据过滤后的总数量
        data: 获得的具体数据
        注意：recordsTotal和recordsFiltered都设置为记录的总条数

        $result = [
        'draw'            => $request->get('draw'),
        'recordsTotal'    => $count,
        'recordsFiltered' => $count,
        'data'           => $data
        ]; */
        if ($request->ajax()) {
            //获取请求头携带的信息
            $count = Article::count();
            $start = $request->start;
            $length = $request->length;
            //获取排序信息
            $list = $request->get('order')[0]['column'];
            //获取排序方式
            $type = $request->get('order')[0]['dir'];
            //获取排序字段
            $column = $request->get('columns')[$list]['data'];

            //接收搜索的参数
            $keyword = $request->get('keyword') ?? '';
            $starttime = $request->get('starttime') ? strtotime($request->get('start')) : null;
            $end = $request->get('end') ? strtotime($request->get('end')) : time();
            $data = Article::with('cate')->when($starttime, function ($query) use ($starttime, $end) {
                $query->whereBetween('create_time', [$starttime, $end]);
            })->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
                ->offset($start)
                ->limit($length)
                ->orderBy($column, $type)
                ->get();
            // $data = Article::with('cate')
            // ->offset($start)
            // ->limit($length)
            // ->orderBy($column,$type)
            // ->get();
            //固定返回客户端的json格式
            return [
                'draw' => $request->draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ];
        }
        //$data = Article::with('cate')->limit(120)->get();
        return view('Admin/Article/list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::all()->toArray();
        $data = get_cate_list($data);
        return view('Admin/Article/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleAdd $request)
    {
        $data = $request->except('_token');
        $data['url'] = '';
        try {
            Article::create($data);
        } catch (\Exception $e) {
            error_info();
        }
        success_info();
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
        $cate = Category::all()->toArray();
        $cate = get_cate_list($cate);
        $data = Article::find($id);
        return view('Admin/Article/edit', compact('cate', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleAdd $request, $id)
    {
        //需求：添加成功后仍留在当前页面
        $data = $request->except('_token');
        $url = route('article.index').'?';
        $url.=$data['data'];
        //避免入库字段冲突
        unset($data['data']);
        try {
            Article::where('id', $id)->update($data);
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
       try{
            $article->delete();
       }catch(\Exception $e){
            error_info($e->getMessage());
       }
       success_info();
    }

    

    public function unlink(Request $request)
    {
        $src = public_path($request->src);
        if (file_exists($src)) {
            @unlink($src);
        }
        success_info();
    }
}
