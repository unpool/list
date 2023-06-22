<?php

namespace App\Http\Requests\Admin\Channel;

use Illuminate\Foundation\Http\FormRequest;

class SendNewMassageRequest extends FormRequest
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
        $fileType = 'mimes:jpg,bmp,png,pdf,mp4';

        return [
            'body' => ['required', 'string', 'min:1', 'max:400'],
            // 'file' => [ 'required_if:body,==,null', 'file' , 'max:100000', 'mime']
        ];
    }
}
