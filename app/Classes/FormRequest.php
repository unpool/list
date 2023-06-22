<?php

namespace App\Classes;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class FormRequest extends LaravelFormRequest {

    protected $user_id_key;

    private function actionName() {

        $controller = Route::getFacadeRoot()->current()->getAction()['controller'];

        $controllerArray = explode('@', $controller);

        return end($controllerArray);
    }

    protected function actionRule() {

        $method = 'rule' . ucfirst(Str::camel($this->actionName()));

        if(method_exists($this, $method))
            return $this->$method();

        return [];
    }

    protected function actionAuthorize() {

        $method = 'authorize' . ucfirst(Str::camel($this->actionName()));

        if(method_exists($this, $method))
            return $this->$method();

        return true;
    }

    protected function getData($key = null, $default = null) {

        if(!is_null($key))
            $key = "data.{$key}";

        return $this->input($key, $default);
    }

    protected function failedValidation(Validator $validator) {

        if(request()->wantsJson()) {

            $messages = $validator->errors()->getMessages();
            $messagesArray = [];

            foreach ($messages as $messageKey => $keyMessages) {

                foreach ($keyMessages as $message) {

                    $messagesArray[] = [
                        'key' => $messageKey,
                        'text' => $message,
                        'type' => 'warning'
                    ];
                }
            }

            throw new HttpResponseException(response()->json([
                'status' => false,
                'messages' => $messagesArray
            ], Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    public function validationData() {

        $all = $this->all();

        $all = $this->exists('data') ? $all['data'] : $all;

        if(!is_null($this->user_id_key)) {

            $all = array_merge($all, [
                $this->user_id_key => id()
            ]);
        }

        return $all;
    }
}
