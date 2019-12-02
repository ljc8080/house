<?php

namespace App\Model;


class Article extends BaseModel
{
    protected $appends = ['btn'];
    public function cate()
    {
        return $this->belongsTo(Category::class, 'cid');
    }
    public function getCreateTimeAttribute($key)
    {
        return  $this->attributes['create_time'] = date('Y-m-d H:i:s', $key);
    }

    public function getBtnAttribute()
    {
        return $this->edit('article.edit') . ' ' . $this->del('article.destroy');
    }

    public function getPicAttribute($key)
    {
        return 'http://www.house.com/uploads/article/' . $key;
    }
}
