<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'name' => 'required|string',
            'score' => 'required|string',
            'period' => 'required|string',
            'price'  => 'required|string',
            'share_invited' => 'required|string',
            'is_special' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام',
            'score'  => 'امتیاز',
            'period'  => 'مدت زمان',
            'price'  => 'قیمت',
            'share_invited'  => 'سهم معرف',
            'is_special'  => 'ویژه',
        ];
    }
}
