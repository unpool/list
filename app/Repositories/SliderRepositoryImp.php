<?php

namespace App\Repositories;



interface SliderRepositoryImp extends BaseRepositoryImp
{
    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator;

    /**
     * @param int $id
     * @return int
     */
    public function forceDelete(int $id);
}
