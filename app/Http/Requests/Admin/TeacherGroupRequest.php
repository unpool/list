<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\BaseRequest as FormRequest;

class TeacherGroupRequest extends FormRequest
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

    public function rules(): array
    {
        switch ($this->actionName()) {
            case 'store':
                $rules = [
                    'groupHead' => 'required',
                    'members' => 'required|array'
                ];
                break;
            case 'update':
                $rules = [
                    'groupHead' => 'required',
                    'members' => 'required|array'
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
}
