<?php
/**
 * Created by PhpStorm.
 * User: hesam
 * Date: 9/19/19
 * Time: 4:43 PM
 */

namespace App\Builders;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseBuilder
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function count():int
    {
        return $this->model->count();
    }

    /**
     * @return \App\User[]|Collection
     */
    public function get():Collection
    {
        return $this->model->get();
    }
}