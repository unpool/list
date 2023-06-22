<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BuildInfrastructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'infrastructure:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Infrastructure for site and admin panel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (\App\Models\Admin::count() === 0) {
            $this->createSuperAdminItem();
        }

        if (Role::where('name', \App\Enums\RoleType::TEACHER)->count() === 0) {
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
        $this->info('Done!');
    }

    /**
     * @return void
     */
    private function createSuperAdminItem()
    {
        \App\Models\Admin::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('000000')
        ]);
    }
}
