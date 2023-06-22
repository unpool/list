<?php

namespace App\Repositories;


use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;


class PermissionRepository extends BaseRepository implements PermissionRepositoryImp
{
    /**
     * @param Spatie\Permission\Models\Permission $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }


    /**
     * @param string $guard
     * @return void
     *
     * guards: admin, teacher
     */
    public function createPermissions(string $guard)
    {

        if (key_exists($guard, config('auth.guards', []))) {

            /** @var \Illuminate\Routing\RouteCollection $routes */
            $routes = Route::getRoutes()->getRoutesByName();

            $guardRoutes = [];
            $now = date('Y-m-d H:i:s');
            $changeablePermissions = config('permission.changeable', []);

            /** @var \Illuminate\Routing\Route $route */
            foreach ($routes as $routeName => $route) {

                if (strpos($routeName, $guard) !== false) {

                    $guardRoutes[] = [
                        'guard_name' => $guard,
                        'name' => get_permission_name($routeName, $guard),
                        'changeable' => (int) in_array($routeName, $changeablePermissions),
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
            }

            $this->model->where([
                ['guard_name', '=', $guard]
            ])->delete();

            $this->model->insert($guardRoutes);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissionsByGuard(string $guard): \Illuminate\Database\Eloquent\Collection
    {

        $permissions = $this
            ->model
            ->where([
                ['guard_name', '=', $guard]
            ])
            ->get();
        return $permissions;
        // return $this->response([
        //     'permissions' => $permissions
        // ])->setStatus(true);
    }

    /**
     * @return Permission|null
     */
    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }

    /**
     * return id of all teacher Permissin
     * @return array
     */
    public function allTeacherPermissionsId(): array
    {
        return [
            $this->model->where('name', \App\Enums\PermissionType::COMMENT_MANAGE)->first()->id,
            $this->model->where('name', \App\Enums\PermissionType::PRODUCT_MANAGE)->first()->id,
        ];
    }
}
