<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'id',
        'key',
        'value',
    ];

    public $casts = [
        'created_at:datetime',
        'updated_at:datetime',
    ];
}
