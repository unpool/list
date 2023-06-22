<?php

namespace App\Repositories;



interface CheckoutRepositoryImp extends BaseRepositoryImp
{
    /**
     * @param int $user_id
     * @return mixed
     */
    public function getIndexByUserId(int $user_id);
}
