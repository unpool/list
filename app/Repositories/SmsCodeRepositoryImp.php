<?php

namespace App\Repositories;



interface SmsCodeRepositoryImp extends BaseRepositoryImp
{
    public function SendValidationCode(string $phone_number);
}
