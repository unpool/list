<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invite
 *
 * @property int $id
 * @property int $user_id
 * @property int $invited_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $invited
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereInvitedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereUserId($value)
 * @mixin \Eloquent
 */
class Invite extends Model
{
    /**
     * @var string
     */
    protected $table = 'invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'invited_id', 'created_at', 'update_at'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function invited()
    {
        return $this->belongsTo(User::class, 'invited_id', 'id');
    }
}
