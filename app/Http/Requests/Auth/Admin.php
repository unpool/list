<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class Admin extends BaseRequest
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
    public function rules():array
    {
        $rules = [];
        switch ($this->actionName()) {
            case 'login':
                $rules = [
                    'email' => 'required|email',
                    'password' => 'required|min:6'
                ];
                break;
            default:
                break;
        }
        return $rules;
    }
}
