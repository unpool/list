<?php

namespace App\Repositories;


use App\Enums\PriceType;
use App\Models\Price;

class PriceRepository extends BaseRepository implements PriceRepositoryImp
{

    /**
     * AdminRepository constructor.
     * @param Price $model
     */
    public function __construct(Price $model)
    {
        parent::__construct($model);
    }

    public function getShare(array $product_ids): string
    {
        return $this->model->whereIn('node_id',$product_ids)->where('type',PriceType::COIN)->sum('amount');
    }
}
