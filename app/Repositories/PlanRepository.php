<?php

namespace App\Repositories;



use App\Models\Plan;

class PlanRepository extends BaseRepository implements PlanRepositoryImp
{
    /**
     * PlanRepository constructor.
     * @param Plan $model
     */
        public function __construct(Plan $model)
        {
              parent::__construct($model);

        }
}
