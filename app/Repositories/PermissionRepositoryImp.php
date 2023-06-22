<?php

namespace App\Repositories;


interface PermissionRepositoryImp extends BaseRepositoryImp
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissionsByGuard(string $guard): \Illuminate\Database\Eloquent\Collection;

    /**
     * @return \Spatie\Permission\Models\Permission|null
     */
    public function findByName(string $name);

    /**
     * return id of all teacher Permissin
     * @return array
     */
    public function allTeacherPermissionsId(): array;
}
