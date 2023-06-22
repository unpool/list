<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class Teacher extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->actionName()) {
            case 'store':
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|unique:teachers',
                    'password' => 'required|min:6',
                ];
                break;
            case 'update':
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|unique:teachers,email,' . $this->getParamaterFromRoute('id'),
                    'password' => 'nullable|min:6',
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
    /**
     * get parameter from route
     * @param  string $parameter parameter name
     * @return null|string
     */
    private function getParamaterFromRoute(string $parameter)
    {
        return $this->route()->parameter($parameter);
    }
}
