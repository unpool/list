<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
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
            'type' => ['required', 'in:sms,pushe'],
            'users' => ['array', 'required', 'min:1'],
            'users.*' => ['numeric', 'exists:users,id'],
        ];
    }
}
