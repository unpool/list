<?php

namespace App;

use App\Enums\MediaType;
use App\Models\AccountBank;
use App\Models\Channel;
use App\Models\Checkout;
use App\Models\Conversation;
use App\Models\Invite;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Role;
use App\Models\Media;
use App\Models\Deposit;
use App\Models\Note;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\UserIMIE;
use App\Traits\DatetimeAccessorTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Morilog\Jalali\CalendarUtils;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $invite_code
 * @property string $fcm_token
 * @property string $password
 * @property string $province
 * @property string $city
 * @property string $job
 * @property string $address
 * @property string $wallet
 * @property string $score
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|AccountBank[] $accountsBanks
 * @property-read Collection|Conversation[] $conversations
 * @property-read UserIMIE $imie
 * @property-read Invite $invitedFrom
 * @property-read Collection|Invite[] $invites
 * @property-read Collection|Notification[] $notifications
 * @property-read Collection|Order[] $orders
 * @property-read Collection|Transaction[] $transactions
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereBirthDate($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFcmToken($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereInviteCode($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereMobile($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, DatetimeAccessorTrait, SoftDeletes;

    protected $dates = [
        'chance_wheeled_at'
    ];

    public function fullName()
    {
        return "$this->first_name $this->last_name";
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getInviteByAttribute()
    {
        if ($this->invitedFrom) {
            return $this->invitedFrom;
        }
        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    |*/

    /**
     * @param $query
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Builder
     */
    public function scopeFilterByBirthday($query, \DateTime $from, \DateTime $to): Builder
    {
        return $query->where('birth_date', '>=', $from)
            ->where('birth_date', '<=', $to);
    }

    /**
     * @param $query
     * @param Carbon $from
     * @param Carbon $to
     * @return Builder
     */
    public function scopeFilterByCreatedAt($query, Carbon $from, Carbon $to): Builder
    {
        return $query->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to);
    }

    /**
     * @return string
     */
    public function getJalaliBirthDateAttribute()
    {
        return CalendarUtils::convertNumbers(CalendarUtils::strftime('Y/m/d', $this->birth_date));
    }

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [

        'id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'birth_date',
        'invite_code',
        'fcm_token',
        'password',
        'wallet',
        'province',
        'city',
        'score',
        'job',
        'address',
        'deleted_at',
        'share',
        'expiring_date',
        'admin_notes',
        'chance_wheeled_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    |*/

    /**
     * @return HasMany
     */
    public function accountsBanks()
    {

        return $this->hasMany(AccountBank::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class,'user_id' , 'id');
    }
    /**
     * @return MorphMany
     */
    public function conversations()
    {
        return $this->morphMany(Conversation::class, 'conversationable');
    }

    /**
     * @return HasMany
     */
    public function invites()
    {
        return $this->hasMany(Invite::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */

    public function invitedByUser()
    {
        return $this->belongsTo(Invite::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function invitedBy()
    {
        return $this->belongsToMany(User::class, Invite::class, 'invited_id', 'user_id');
    }

    /**
     * @return User
     */
    public function invitedFromUser()
    {
        return $this->belongsToMany(User::class, Invite::class, 'user_id', 'invited_id')->first();
    }

    /**
     * @return BelongsToMany
     */
    public function invitedFrom()
    {
        return $this->belongsToMany(User::class, Invite::class, 'invited_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function imies()
    {
        return $this->hasMany(UserIMIE::class);
    }

    /**
     * @return HasOne
     */
    public function imie()
    {
        return $this->hasOne(UserIMIE::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    /**
     * @return MorphToMany
     */
    public function image()
    {
        return $this->morphToMany(Media::class, 'mediable')
            ->wherePivot('type', '=', MediaType::IMAGE);
    }

    /**
     * @return HasMany
     */
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @inheritDoc
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function discount()
    {
        return $this->morphOne(Discount::class, 'discountable');
    }

    public function setPasswordWithCode(string $new_password): bool
    {
        return $this->update(['password' => bcrypt($new_password)]);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function checkout()
    {
        return $this->hasMany(Checkout::class);
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function channels(){
        return $this->belongsToMany(Channel::class, 'channel_user');
    }
}
