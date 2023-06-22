<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Enum
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereValue($value)
 * @mixin \Eloquent
 */
class Enum extends Model
{
    /**
     * @var string
     */
    protected $table = 'enums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'key', 'value', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @var bool
     */
    public $timestamps = true;
}
