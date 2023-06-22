<?php

namespace App\Repositories;


/**
 * Interface PriceRepositoryImp
 * @package App\Repositories
 */
interface PriceRepositoryImp extends BaseRepositoryImp
{
    /**
     * @param array $product_ids
     * @return string
     */
    public function getShare(array $product_ids):string;
}
