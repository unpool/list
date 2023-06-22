<?php

namespace App\Repositories;


use App\Models\Order;

interface OrderRepositoryImp extends BaseRepositoryImp
{
    public function create(array $attributes);

    public function calculateAndAddSource(Order $order);

    public function calculateAndRemoveSource(Order $order);

    public function getOrdersByUserId(int $user_id);


}
