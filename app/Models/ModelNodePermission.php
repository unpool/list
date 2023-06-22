<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelNodePermission extends Model
{
    protected $table = 'model_node_permissions';

    protected $fillable = ['model_id', 'model_type', 'node_id'];
}
