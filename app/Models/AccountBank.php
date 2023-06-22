<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

/**
 * App\Models\AccountBank
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereUserId($value)
 * @mixin \Eloquent
 */
class AccountBank extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'accounts_banks';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'user_id', 'first_name', 'last_name', 'account_number', 'created_at', 'updated_at',
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

	public function fullName()
	{
		return "$this->first_name $this->last_name";
	}

	/**
	 * @return string
	 */
	public function getJalaliCreatedAtAttribute(): string
	{
		return CalendarUtils::convertNumbers(CalendarUtils::strftime('Y/m/d H:i:s', $this->created_at));
	}

	/*
		    |--------------------------------------------------------------------------
		    | Relations
		    |--------------------------------------------------------------------------
	*/

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{

		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
