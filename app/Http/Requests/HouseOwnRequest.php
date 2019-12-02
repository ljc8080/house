<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class HouseOwnRequest extends FormRequest
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
        $this->myrules();
        return [
            'name'=>'required|name',
            'age'=>'required|numeric|min:1|max:120',
            'address'=>'required|max:255',
            'pic'=>'required',
            'sex'=>'required',
            'email'=>'required|email',
            'phone'=>'required|phone',
            'card'=>'required|card',
        ];
    }

    private function myrules(){
        Validator::extend('name',function($attr,$val,$param,$validator){
            $reg = "/^[\x{4e00}-\x{9fa5}]+$/u";
            return preg_match($reg,$val);
        });
        Validator::extend('card',function($attr,$val,$param,$validator){
            $reg = 
            "/^[1-9]\d{5}(18|19|20|(3\d))\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/";
            return preg_match($reg,$val);
        });

        Validator::extend('phone',function($attr,$val,$param,$validator){
            $reg = "/^1[3-9]\d{9}$/";
            return preg_match($reg,$val);
        });
    }

    public function message(){
        return [
            'name.name'=>'名称不合法',
            'phone.phone'=>'手机号不合法',
            'card.card'=>'身份证不合法'
        ];
    }
}
