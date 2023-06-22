<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest as FormRequest;

class ProductRequest extends FormRequest
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
                    'title' => 'required',
                    'description' => 'required',
                    'category' => 'required',
                    'price' => 'required',
                    'price_coin' => 'required',
                    'dvd_price' => 'required',
                    'flash_price' => 'required',
                    'group' => 'required',
                    'status' => 'required',
                    'score' => 'required|integer|min:0'
                ];
                break;
            case 'update':
                $rules = [
                    'title' => 'required',
                    'description' => 'required',
                    'category' => 'required',
                    'price' => 'required',
                    'price_coin' => 'required',
                    'image' => 'image',
                    'group' => 'required',
                    'status' => 'required',
                    'score' => 'required|integer|min:0'
                ];
                break;
            case 'fileUploader':
                $rules = [
                    'file' => 'required|file'
                ];
                break;
            case 'changeFileOrder':
                $product_id = $this->getParamaterFromRoute('id');
                $product = \App\Models\Node::where('is_product', true)->where('id', $product_id)->firstOrFail();
                $rules = [
                    'order' => [
                        'required',
                        'integer',
                        'min:1',
                        "max:{$product->medias()->count()}"
                    ]
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
