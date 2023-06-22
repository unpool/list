<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\BaseRequest;

class Node extends BaseRequest
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
                    'category' => 'nullable|exists:nodes,id',
                    'title' => 'required',
                ];
                break;
            case 'update':
                $rules = [
                    'price' => 'required|numeric',
                    'image' => 'nullable|image'
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
}
