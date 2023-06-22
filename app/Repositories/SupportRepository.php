<?php

namespace App\Repositories;

use App\Models\Support;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class SupportRepository extends BaseRepository implements SupportRepositoryImp
{
    /**
     * CheckoutRepository constructor.
     * @param Checkout $model
     */
    public function __construct(Support $model)
    {
        parent::__construct($model);

    }
    public function getIndexByUserId(int $user_id)
    {
        return $this->model->where('user_id',$user_id)->orderBy('id','desc')->paginate();
    }

}
