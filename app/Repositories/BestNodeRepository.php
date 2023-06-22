<?php

namespace App\Repositories;

use App\Models\BestNode;

class BestNodeRepository extends BaseRepository implements BestNodeRepositoryImp
{
    /**
     * BestNodeRepository constructor.
     * @param BestNode $model
     */
    public function __construct(BestNode $model)
    {
        parent::__construct($model);
    }

    public function getBestNodeOrderDesc()
    {
        return $this->model->orderBy('id','desc')->paginate();
    }
}
