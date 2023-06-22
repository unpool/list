<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentType
 *
 * @property int $id
 * @property int $order_id
 * @property float $price
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentType extends Model
{
    /**
     * @var string
     */
    protected $table = 'payment_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'price', 'type', 'order_id', 'created_at', 'updated_at'
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

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
