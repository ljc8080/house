<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseAttr extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pid'=>'required|numeric|gte:0',
            'name'=>'required|min:1|max:20',
            'icon'=>'required'
        ];
    }

    

}
