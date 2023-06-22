<?php

namespace App\Repositories;



use App\Models\Checkout;

class CheckoutRepository extends BaseRepository implements CheckoutRepositoryImp
{
      /**
           * CheckoutRepository constructor.
           * @param Checkout $model
           */
        public function __construct(Checkout $model)
        {
              parent::__construct($model);

        }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function getIndexByUserId(int $user_id)
    {
        return $this->model->where('user_id',$user_id)->orderBy('id','desc')->paginate();
    }
}
