<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Repositories\PermissionRepository;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class PermissionReset extends Command {

    protected $name = 'permission:reset';

    protected $description = 'reset guard permissions';

    private $permissionRepo;

    public function __construct(Filesystem $files, PermissionRepository $permissionRepository)
    {
        parent::__construct($files);

        $this->permissionRepo = $permissionRepository;
    }


    public function handle() {

        $this->resetPermissions();
    }


    protected function resetPermissions() {

        $guard = $this->getGuardName();

        if(!key_exists($guard, config('auth.guards'))) {

            $this->error('guard does not exists.');
            exit(1);
        }

        $repoNamespace = '\\App\\Repositories\\' . ucfirst($guard) . 'Repository';
        $modelNamespace = '\\App\\Models\\'. ucfirst($guard);

        $repo = new $repoNamespace((new $modelNamespace()));

        $permissions = $this->permissionRepo->getPermissionsByGuard($guard);
        $users = $repo->all();

        foreach ($users as $user) {

            $repo->changePermissions($user, $permissions->permissions->pluck('name')->all());
        }

        $this->line('permissions successfully reset.');
        exit(0);
    }

    protected function getGuardName() {

        return trim($this->argument('GuardName'));
    }

    protected function getArguments() {

        return [
            ['GuardName', InputArgument::REQUIRED, 'The name of guard must create permissions'],
        ];
    }
}
