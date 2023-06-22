<?php

namespace App\Repositories;


use App\Traits\ClassTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryImp
{

    use ClassTrait;

    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

 /**
     * @param array $attributes
     * @return mixed
     */
    public function createOrUpdate(array $attributes,array $values = [])
    {
        return $this->model->updateOrCreate($attributes,$values);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function update(array $attributes, int $id): bool
    {
        return $this->find($id)->update($attributes);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     * @param array $data
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginateArrayResults(array $data, int $perPage = 20)
    {
        $page = request()->get('page', 1);
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($data, $offset, $perPage, false),
            count($data),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        return !is_null($with)
            ? $this->model
            ->orderBy($orderBy, $sortType)
            ->with($with)
            ->paginate($limit)
            : $this->model
            ->orderBy($orderBy, $sortType)
            ->paginate($limit);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * @param string $column
     * @param array $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByWhereIn(string $column, array $value): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->whereIn($column, $value)->get();
    }
}
