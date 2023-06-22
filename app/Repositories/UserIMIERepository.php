<?php

namespace App\Repositories;

use App\Models\UserIMIE;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class UserIMIERepository extends BaseRepository implements UserIMIERepositoryImp
{
    public function __construct(UserIMIE $model)
    {
        parent::__construct($model);
    }


    /**
     * @param User $user
     * @param string $IMIE
     * @return void
     */
    public function createOrReplaceNewIMIE(User $user, string $IMIE)
    {
        /** @var Collection $userIMIEs */
        $userIMIEs = $this->getUserIMIEs($user);

        /** @var int $imieCount */
        $imieCount = $userIMIEs->count();
        if ($imieCount >= \App\Models\UserIMIE::MAX_IMIE_FOR_USER) {
            /** @var \App\Models\UserIMIE $imie */
            return $userIMIEs->contains('imie', $IMIE);
        } else {
            $this->createOrUpdate([
                'user_id' => $user->id,
                'imie' => $IMIE
            ], ['user_id', 'imie']);
            return true;

        }
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getUserIMIEs(User $user): Collection
    {
        return $user->imies;
    }
}
