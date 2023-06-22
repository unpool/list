<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

interface ConversationRepositoryImp
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;
}
