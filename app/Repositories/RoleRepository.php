<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;


class RoleRepository extends BaseRepository implements RoleRepositoryImp
{
    /**
     * @param Spatie\Permission\Models\Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * @return \Spatie\Permission\Models\Role|null
     */
    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }
}
