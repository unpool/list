<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatetimeAccessorTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $type
 * @property string $value
 * @property string|null $description
 * @property bool $is_global
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereIsGlobal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereValue($value)
 * @mixin \Eloquent
 */
class Discount extends Model
{
    use DatetimeAccessorTrait, SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'discounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'code', 'type', 'discountable_id', 'discountable_type', 'value', 'description', 'is_global', 'start_at', 'end_at', 'created_at',
        'updated_at'
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
    protected $casts = [
        'is_global' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the owning discountable model.
     */
    public function discountable()
    {
        return $this->morphTo();
    }
}
