<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Repositories\PermissionRepository;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class PermissionGenerate extends Command {

    protected $name = 'permission:generate';

    protected $description = 'create guard permissions';

    private $permissionRepo;

    public function __construct(Filesystem $files, PermissionRepository $permissionRepository)
    {
        parent::__construct($files);

        $this->permissionRepo = $permissionRepository;
    }


    public function handle() {

        $this->generatePermissions();
    }


    protected function generatePermissions() {

        $guard = $this->getGuardName();

        if(!key_exists($guard, config('auth.guards'))) {

            $this->error('guard does not exists.');
            exit(1);
        }

        $this->permissionRepo->createPermissions($guard);

        $this->line('permissions successfully generated.');
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
