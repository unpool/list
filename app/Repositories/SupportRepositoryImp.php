<?php

namespace App\Repositories;
use App\Models\Support;


interface SupportRepositoryImp extends BaseRepositoryImp
{
    public function getIndexByUserId(int $user_id);

}