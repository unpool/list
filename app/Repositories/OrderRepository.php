<?php

namespace App\Repositories;


use App\Enums\OrderType;
use App\Enums\PriceType;
use App\Models\Node;
use App\Models\Order;
use App\Models\Orderable;
use App\Models\Price;
use App\User;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryImp
{
    private $price;
    public $orderable;

    /**
     * OrderRepository constructor.
     * @param Order $model
     * @param Price $price
     * @param Orderable $orderable
     */
    public function __construct(Order $model, Price $price,Orderable $orderable)
    {
        parent::__construct($model);
        $this->price = $price;
        $this->orderable = $orderable;
    }

    public function create(array $attributes)
    {
        $order = $this->model;
        $node_array = $attributes['nodes'];
//        if(!PriceType::getValues().contains($attributes['send_type']))
//            return response()->json(['message' =>"BAD REQUEST"], JsonResponse::HTTP_BAD_REQUEST);
        $orderables=[];
        $attributes+=['price'=>0];
        foreach ($node_array as $node){
            $orderable = $this->price::where(['type' => $node['send_type']])
                ->where('node_id', $node['node_id'])->first(['node_id as nodeable_id', 'amount as price'])->toArray();
            $orderable['nodeable_type'] = $node['send_type'];
            array_push($orderables,$orderable);
            $attributes['price'] = $attributes['price'] +$orderable['price'];
        }
        $attributes['type'] = OrderType::BUYNODE;
        $order = $order->create($attributes);
        $order->orderables()->createMany($orderables);
        return $order;
    }


    public function calculateAndAddSource(Order $order){

        $ids=$order->nodes()->get()->pluck('id');
        $totalSources=Node::whereIn('id',$ids)->sum('score');
        $total_invited_price=Price::whereIn('node_id',$ids)->where('type',PriceType::COIN)->sum('amount');
        /**
         * @var $invitedUser User
         */
       $user=$order->user()->first();
        if ($user) {
            $user->score = $user->score + $totalSources;
            $user->save();
        }

       $invitedUser=$user->invitedFromUser();
       if ($invitedUser) {
           $invitedUser->share = $invitedUser->share + $total_invited_price;
           $invitedUser->save();
       }
    }

    public function calculateAndRemoveSource(Order $order){

        $ids=$order->nodes()->get()->pluck('id');
        $totalSources=Node::whereIn('id',$ids)->sum('score');
        $total_invited_price=Price::whereIn('node_id',$ids)->where('type',PriceType::COIN)->sum('amount');
        /**
         * @var $invitedUser User
         */
        $user=$order->user()->first();
        if ($user) {
            $user->score = $user->score - $totalSources;
            $user->save();
        }

        $invitedUser=$user->invitedFromUser();
        if ($invitedUser) {
            $invitedUser->share = $invitedUser->share - $total_invited_price;
            $invitedUser->save();
        }
    }


    public function getOrdersByUserId(int $user_id)
    {
        return $this->model->where(['user_id' => $user_id])->paginate();
    }
}
