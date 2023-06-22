<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nodes' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'send_type' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'کاربر',
            'send_type' => 'روش ارسال',
            'node_id' => 'پکیج ها',
            'node_id.*' => 'پکیج ها',
        ];
    }
}
