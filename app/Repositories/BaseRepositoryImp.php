<?php

namespace App\Repositories;


interface BaseRepositoryImp
{
    public function create(array $attributes);

    public function update(array $attributes, int $id);

    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc');

    public function find(int $id);

    public function findOneOrFail(int $id);

    public function findBy(array $data);

    public function findOneBy(array $data);

    public function findOneByOrFail(array $data);

    public function paginateArrayResults(array $data, int $perPage = 50);

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator;

    public function delete(int $id);

    public function count(): int;
    /**
     * @param string $column
     * @param array $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByWhereIn(string $column, array $value): \Illuminate\Database\Eloquent\Collection;
}
