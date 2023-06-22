<?php

namespace App\Repositories;


interface InviteRepositoryImp extends BaseRepositoryImp
{
    /**
     * @param string $invite_code
     * @param int $user_id
     * @return bool
     */
    public function validationCode(string $invite_code, int $user_id): bool;
}
