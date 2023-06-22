<?php

namespace App\Repositories;



class SliderRepository extends BaseRepository implements SliderRepositoryImp
{
      /**
       * SliderRepository constructor.
       * @param \App\Models\Slider $model
       */
      public function __construct(\App\Models\Slider $model)
      {
            parent::__construct($model);
      }
      /**
       * @param int $limit
       * @param string $orderBy
       * @param string $sortType
       * @param  array $with
       * @return LengthAwarePaginator
       */
      public function getPaginatedList(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator
      {
            if (is_null($with)) {
                  $items = $this->model
                        ->orderBy($orderBy, $sortType)
                        ->paginate($limit);
            } else {
                  $items = $this->model
                        ->orderBy($orderBy, $sortType)
                        ->with($with)
                        ->paginate($limit);
            }
            foreach ($items->items() as $key => $value) {
                  $value->fromRootToCategory = join(' / ', $value->node->getAncestorsAndSelf()->pluck('title')->toArray() ?? []);
            }
            return $items;
      }

      /**
       * @param int $id
       * @return int
       */
      public function forceDelete(int $id)
      {
            $item = $this->findOneOrFail($id);
            return $item->forceDelete();
      }
}
