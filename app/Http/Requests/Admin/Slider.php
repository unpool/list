<?php

namespace App\Http\Requests\Admin;

use App\Classes\FormRequest;

class Slider extends FormRequest
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
        return $this->actionRule();
    }

    protected function ruleStore(): array
    {
        return [
            'title' => 'required',
            'url' => 'required|url',
            'file' => 'required',
            'description' => 'required',
            'category' => 'required'
        ];
    }
}
