<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest as FormRequest;

class PackageRequest extends FormRequest
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

    public function prepareForValidation()
    {
        switch ($this->actionName()) {
            case 'store':
                if ($this->has('products')) {
                    $products = [];
                    foreach ($this->get('products') as $item) {
                        if ($item and is_numeric($item))
                            $products[] = (int) $item;
                    }
                }
                $this->merge([
                    'products' => array_unique($products)
                ]);
                break;
            case 'update':
                if ($this->has('products')) {
                    $products = [];
                    foreach ($this->get('products') as $item) {
                        if ($item and is_numeric($item))
                            $products[] = (int) $item;
                    }
                }
                $this->merge([
                    'products' => array_unique($products)
                ]);
                break;
            default:
                break;
        }
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
                    'group' => 'required',
                    'products' => [
                        'required',
                        'array'
                    ],
                    'products.*' => 'in:' . implode(',', \App\Models\Node::where('is_product', true)->pluck('id')->toArray()),
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
                    'group' => 'required',
                    'products' => [
                        'required',
                        'array'
                    ],
                    'products.*' => 'in:' . implode(',', \App\Models\Node::where('is_product', true)->pluck('id')->toArray()),
                    'status' => 'required',
                    'score' => 'required|integer|min:0'
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'products' => 'محصولات',
            'products.*.in' => 'شناسه محصول معتبر نیست'
        ];
    }
}
