<?php

namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Collection;

interface UserIMIERepositoryImp extends BaseRepositoryImp
{
    /**
     * @param User $user
     * @param string $IMIE
     * @return void
     */
    public function createOrReplaceNewIMIE(User $user, string $IMIE);

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserIMIEs(User $user): Collection;
}
