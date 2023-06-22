<?php

namespace App\Repositories;



class TransactionRepository extends BaseRepository implements TransactionRepositoryImp
{
      /**
           * TransactionRepository constructor.
           * @param \App\Models\Transaction $model
           */
        public function __construct(\App\Models\Transaction $model)
        {
              parent::__construct($model);

        }
}
