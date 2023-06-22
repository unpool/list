<?php

namespace App\Http\Requests\Api;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use JWTAuth;

class UserRequest extends FormRequest
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
        $user = JWTAuth::authenticate($this->get('token'));
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'unique:users,email,' . $user->id . '|email',
            'mobile' => 'unique:users,mobile,' . $user->id . '|regex:/^09[0-9]{9}$/',
            'birth_date' => 'string',
            'password' => 'min:6|string',
            'image' => 'image',
            'job' => 'string',
            'province' => 'string',
            'city' => 'string',
            'address' => 'string'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [

            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'email' => 'ایمیل',
            'mobile' => 'تلفن همراه',
            'password' => 'کلمه عبور',
            'birth_date' => 'تاریخ تولد',
            'invite_code' => 'کد دعوت',
            'image' => 'تصویر پروفایل',
            'job' => 'شغل',
            'province' => 'استان',
            'city' => 'شهر',
            'address' => 'آدرس',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['messages' => $errors,
        ], JsonResponse::HTTP_BAD_REQUEST));
    }

}
