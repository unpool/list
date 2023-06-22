<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => \App\Enums\RoleType::TEACHER,
            'guard_name' => 'teacher'
        ]);
        $permission = Permission::create([
            'name' => \App\Enums\PermissionType::PRODUCT_MANAGE,
            'guard_name' => 'teacher'
        ]);
        $role->givePermissionTo($permission);
        $permission = Permission::create([
            'name' => \App\Enums\PermissionType::COMMENT_MANAGE,
            'guard_name' => 'teacher'
        ]);
        $role->givePermissionTo($permission);
    }
}
