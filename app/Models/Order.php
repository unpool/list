<?php

namespace App\Models;

use App\Enums\PriceType;
use App\Traits\DatetimeAccessorTrait;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property float $price
 * @property int $discount_id
 * @property float $discount_price
 * @property bool $is_paid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Baum\Extensions\Eloquent\Collection|Node[] $nodes
 * @property-read Collection|PaymentType[] $paymentTypes
 * @property-read User $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDiscountId($value)
 * @method static Builder|Order whereDiscountPrice($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereIsPaid($value)
 * @method static Builder|Order wherePrice($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use SoftDeletes, DatetimeAccessorTrait;
    /**
     * @var bool
     */
    protected $softDelete = true;

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'price', 'discount_price', 'discount_id', 'is_paid', 'created_at', 'updated_at', 'send_type', 'type'
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
        'is_paid' => 'boolean'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return HasMany
     */
    public function orderables()
    {
        return $this->hasMany(Orderable::class, 'order_id', 'id');
    }
 /**
     * @return HasMany
     */
    public function nodes()
    {
        return $this->belongsToMany(Node::class, Orderable::class, 'order_id','nodeable_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function paymentTypes()
    {
        return $this->hasOne(PaymentType::class, 'order_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id', 'id');
    }

    /**
     * @return string
     */
    public function getShowPaidAttribute()
    {
        return $this->is_paid ? "پرداخت شده" : "پرداخت نشده";
    }

    /**
     *
     */
    public function chargeWalletAfterPaymentByShareInvited()
    {
        $invites = $this->user->invites;
        $nodes = $this->orderables()->pluck('node_id');
        $sum = Price::where('type', PriceType::COIN)->whereIn('node_id', $nodes)->sum('amount');
        if (!empty($invites)) {
            foreach ($invites as $invite) {
                $invite->user->share += $sum;
                $invite->user->update();
            }
        }
    }
}
