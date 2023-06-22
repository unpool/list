<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DatetimeAccessorTrait;

/**
 * App\Models\UserIMIE
 *
 * @property int $id
 * @property int $user_id
 * @property string $imie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereImie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereUserId($value)
 * @mixin \Eloquent
 */
class UserIMIE extends Model
{
    use DatetimeAccessorTrait;

    const MAX_IMIE_FOR_USER = 2;

    /**
     * @var string
     */
    protected $table = 'user_imies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'imie', 'create_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'imie'
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
