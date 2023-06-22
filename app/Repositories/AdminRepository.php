<?php

namespace App\Repositories;


use App\Models\Admin;

class AdminRepository extends BaseRepository implements AdminRepositoryImp
{

    /**
     * AdminRepository constructor.
     * @param Admin $model
     */
    public function __construct(\App\Models\Admin $model)
    {
        parent::__construct($model);

    }

    /**
     * @param Admin $admin
     * @param array $permissions
     * @return \App\Classes\ClassResponse
     */
    public function changePermissions(Admin $admin, array $permissions)
    {

        $admin->syncPermissions($permissions);

        return $this->response()
            ->setStatus(true);
    }
}
