<?php

namespace App\Http\Requests\Admin\Channel;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => ['required', 'min:2', 'max:100'],
            'description' => ['nullable', 'min:2', 'max:100'],
            'type' => ['required', 'in:public,private'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
        ];
    }
}
