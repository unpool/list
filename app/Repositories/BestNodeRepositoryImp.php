<?php

namespace App\Repositories;

use App\Models\BestNode;

interface BestNodeRepositoryImp extends BaseRepositoryImp
{
    public function getBestNodeOrderDesc();
}
