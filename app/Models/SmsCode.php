<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SmsCode
 *
 * @property int $id
 * @property string $mobile
 * @property string $code
 * @property string|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereMobile($value)
 * @mixin \Eloquent
 */
class SmsCode extends Model
{
    /**
     * @var string
     */
    protected $table = 'sms_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'mobile', 'code', 'created_at'
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
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

}
