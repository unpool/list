<?php

namespace App\Repositories;


interface RoleRepositoryImp extends BaseRepositoryImp
{
    /**
     * @return \Spatie\Permission\Models\Role|null
     */
    public function findByName(string $name);
}
