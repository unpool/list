<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Orderable
 *
 * @property int $id
 * @property int $orderable_id
 * @property string $orderable_type
 * @property int $order_id
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Order $order
 * @method static Builder|Orderable newModelQuery()
 * @method static Builder|Orderable newQuery()
 * @method static Builder|Orderable query()
 * @method static Builder|Orderable whereCreatedAt($value)
 * @method static Builder|Orderable whereId($value)
 * @method static Builder|Orderable whereOrderId($value)
 * @method static Builder|Orderable whereOrderableId($value)
 * @method static Builder|Orderable whereOrderableType($value)
 * @method static Builder|Orderable wherePrice($value)
 * @method static Builder|Orderable whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Orderable extends Model
{
    /**
     * @var string
     */
    protected $table = 'orderables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'order_id', 'nodeable_id', 'nodeable_type', 'price', 'created_at', 'updated_at',
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

    /**
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function node()
    {
        return $this->belongsTo(Node::class, 'nodeable_id', 'id');
    }

    public function nodeable()
    {
        return $this->morphTo();
    }

}
