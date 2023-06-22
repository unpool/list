<?php

namespace App\Repositories;


use App\Models\AccountBank;

class AccountBankRepository extends BaseRepository implements AccountBankRepositoryImp
{

    protected $account;

    /**
     * AccountBankRepository constructor.
     * @param AccountBank $model
     */
    public function __construct(AccountBank $model)
    {
        parent::__construct($model);
    }
}
