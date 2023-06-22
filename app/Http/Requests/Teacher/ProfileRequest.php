<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;


class ProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    public function rules():array
    {
        switch ($this->actionName()) {
            case 'update':
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => [
                        'required',
                        Rule::unique('teachers')->ignore(login_teacher()->id),
                    ],
                    'cv' => 'required|min:3'
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }

}
