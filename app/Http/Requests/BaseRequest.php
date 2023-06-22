<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class BaseRequest extends FormRequest
{
    /**
     * @return string
     */
    protected function actionName():string
    {
        $controller = Route::getFacadeRoot()->current()->getAction()['controller'];
        $controllerArray = explode('@', $controller);
        return end($controllerArray);
    }
}
