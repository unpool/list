<?php

namespace App\Http\Requests\Admin;

use App\Classes\FormRequest;

class Admin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->actionAuthorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->actionRule();
    }

    protected function ruleUpdate() {

        return [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|email',
            'password'      => 'required|string|confirmed',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'required|string|exists:permissions,name'
        ];
    }
}
