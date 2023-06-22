<?php

namespace App\Models;

use App\Enums\CheckoutType;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\CalendarUtils;

/**
 * @property mixed created_at
 * @property mixed status
 * @property mixed type
 * @property mixed value
 */
class Checkout extends Model
{

    /**
     *
     */
    const UPDATED_AT = null;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'value',
        'type',
        'status',
        'created_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getJalaliCreatedAttribute()
    {
        return CalendarUtils::convertNumbers(CalendarUtils::strftime('Y/m/d H:i:s', $this->created_at));
    }

    /**
     * @return string
     */
    public function getIconStatusAttribute()
    {
        return $this->status ? 'check' : 'times';
    }

    public function chargeWallet()
    {
        if($this->type == CheckoutType::WALLET){
            $user = $this->user;
            $user->share -= $this->value;
            $user->wallet += $this->value;
            $user->update();
        }
    }


}
