<?php

namespace App\Repositories;



use App\Models\Setting;

class SettingRepository extends BaseRepository implements SettingRepositoryImp
{
    /**
     * SettingRepository constructor.
     * @param Setting $model
     */
        public function __construct(Setting $model)
        {
              parent::__construct($model);

        }
}
