<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\HouseListResourceCollection;
use App\Http\Resources\HouseResource;
use App\Model\House;
use App\Model\HouseAttr;
use App\Model\HouseCollect;
use app\Tools\Es;
use Exception;

class HouseController extends BaseController
{
    public function recommend(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'limit' => 'numeric|min:3|max:10'
            ]);
            if (!isset($data['limit'])) $data['limit'] = 5;
            $data = House::where([
                'house_status' => '0',
                'is_recommend' => '1'
            ])->select('house_pic', 'id', 'house_name')->orderBy('create_time', 'desc')->limit($data['limit'])->get()->toArray();
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($data);
    }

    public function houseinfo(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'page' => 'numeric|gt:0',
                'id' => 'numeric|gt:0',
                'keyword' => 'max:20'
            ]);
            if ($request->has('page')) {
                $condition = [
                    'house_status' => '0',
                ];
                if (!empty($request->house_area)) {
                    $condition['house_area'] = $request->house_area;
                }
                if (!empty($request->house_rent_type)) {
                    $condition['house_rent_type'] = $request->house_rent_type;
                }
                if (!empty($request->house_rent_range)) {
                    $condition['house_rent_range'] = $request->house_rent_range;
                }
                if (!$request->has('keyword')) {
                    $data = House::where($condition)->paginate($this->paginate);
                } else {
                    $search = (new Es())->search_doc('house', 'xiaoqu', $data['keyword']);
                    if (!$search) $data = [];
                    $ids = array_column($search['hits']['hits'], '_id');
                    $data = House::whereIn('id', $ids)->where($condition)->paginate($this->paginate);
                }
                success_info(new HouseListResourceCollection($data));
            } elseif ($request->has('id')) {
                $data = House::with('houseown')->where('id', $data['id'])->first()->toArray();
                $config = explode(',', $data['house_config']);
                $data['house_config'] = HouseAttr::whereIn('id', $config)->select('name', 'icon')->get()->toArray();
                $data['house_rent_type'] = HouseAttr::where('id', $data['house_rent_type'])->value('name');
                $data['house_direction'] = HouseAttr::where('id', $data['house_direction'])->value('name');
                success_info($data);
            } else {
                throw new Exception('参数缺失');
            }
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
    }

    //添加或取消收藏
    public function collect(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'house_id' => 'required|numeric|gt:0',
                'openid' => 'required',
                'action' => 'required'
            ]);
            extract($data);
            $res = HouseCollect::where(compact('house_id', 'openid'))->exists();
            if ($data['action'] == '添加收藏') {
                if ($res) throw new Exception('系统繁忙');
                unset($data['action']);
                HouseCollect::create($data);
            } else {
                if (!$res) throw new Exception('系统繁忙');
                HouseCollect::withTrashed()->where(compact('openid', 'house_id'))->forceDelete();
            }
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($action . '成功');
    }

    public function is_collect(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'house_id' => 'required|numeric|gt:0',
                'openid' => 'required',
            ]);
            extract($data);
            $res = HouseCollect::where(compact('house_id', 'openid'))->exists();
            $collect = $res ? '取消收藏' : '添加收藏';
        } catch (\Exception $e) {
            error_info($e->getMessage());
        }
        success_info($collect);
    }
}
