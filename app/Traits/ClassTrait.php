<?php

namespace App\Traits;


use App\Classes\ClassResponse;

trait ClassTrait {

    protected function response($data = []) {

        return new ClassResponse($data);
    }
}
