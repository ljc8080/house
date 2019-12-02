<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleAdd extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'=>'required|min:1|max:300',
            'body'=>'required',
            'pic'=>'required',
            'des'=>'min:5|max:300',
            'cid'=>'required|numeric|gte:0'
        ];
    }
}
