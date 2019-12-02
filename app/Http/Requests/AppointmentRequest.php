<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'dtime'=>'required',
            'cnt'=>'required|min:3|max:500',
            'fangowner_id'=>'required',
            'renting_id'=>'required',
        ];
    }

    public function messages(){
        return [
            'dtime.required'=>'请选择预约时间',
            'cnt.required'=>'请填写备注',
            'cnt.max'=>'备注不得超过500字',
            'cnt.min'=>'备注不得少于3个字',
            'fangowner_id'=>'请选择房东',
            'renting_id'=>'请选择租客',
        ];
    }
}
