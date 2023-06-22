<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mediable
 *
 * @property int $id
 * @property int $mediable_id
 * @property string $mediable_type
 * @property int $media_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Media $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereMediableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereMediableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mediable extends Model
{
    /**
     * @var string
     */
    protected $table = 'mediables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'mediable_id', 'mediable_type', 'media_id', 'type', 'order', 'created_at', 'updated_at'
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
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function mediable()
    {
        return $this->morphto();
    }
}
