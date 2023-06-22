<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class Mota extends Controller
{

    private $repo;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repo = $permissionRepository;
    }

    public function __invoke()
    {
        $this->repo->createPermissions('admin');
    }
}
