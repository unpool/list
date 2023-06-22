<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest as FormRequest;
use Morilog\Jalali\Jalalian;

class ReportRequest extends FormRequest
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

            case 'getShareUser':
            case 'userBirthday':
            case 'getSells':
            case 'userHaveOrder':
            case 'packageByDate':
            case 'userHaveIncome':
            case 'userRegister':
                $this->convertJalaliDateToGregorianFromRequest();
                break;

            default:
                break;
        }
    }

    private function convertJalaliDateToGregorianFromRequest()
    {
        if ($this->has('start')) {
            /** @var Jalalian $birth_date */
            $birth_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->get('start')));
            $this->merge([
                'start' => date('Y-m-d', $birth_date->getTimestamp()),
            ]);
        }
        if ($this->has('end')) {
            /** @var Jalalian $birth_date */
            $birth_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->get('end')));
            $this->merge([
                'end' => date('Y-m-d', $birth_date->getTimestamp()),
            ]);
        }
    }
    public function rules(): array
    {
        switch ($this->actionName()) {
            case 'userRegister':
                $rules = [];
                break;
            case 'userOrderList':
                $rules = [];
                if ($this->method() == 'POST') {
                    $rules = [
                        'user' => 'required'
                    ];
                }
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
