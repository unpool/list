<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\BaseRequest;

class BestNodeRequest extends BaseRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        switch ($this->actionName()) {
            case 'store':
                $rules = [
                    'category' => 'required',
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
}
