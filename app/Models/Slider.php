<?php

namespace App\Models;

use App\Enums\MediaType;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Media[] $images
 * @method static Builder|Slider newModelQuery()
 * @method static Builder|Slider newQuery()
 * @method static Builder|Slider query()
 * @method static Builder|Slider whereCreatedAt($value)
 * @method static Builder|Slider whereDescription($value)
 * @method static Builder|Slider whereId($value)
 * @method static Builder|Slider whereLink($value)
 * @method static Builder|Slider whereTitle($value)
 * @method static Builder|Slider whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Slider extends Model
{
    /**
     * @var string
     */
    protected $table = 'sliders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'description', 'link', 'node_id', 'created_at', 'updated_at','image'
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
     * @return MorphToMany
     */
    public function images()
    {
        return $this->morphToMany(Media::class, 'mediable')
            ->wherePivot('type', '=', MediaType::IMAGE)->withPivot('order')->orderBy('order','asc');
    }
    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediable')->withPivot('type');
    }

    /**
     * @return MorphToMany
     */
    public function voices()
    {
        return $this->morphToMany(Media::class, 'mediable')
            ->wherePivot('type', '=', MediaType::VOICE);
    }

    /**
     * @return MorphToMany
     */
    public function videos()
    {
        return $this->morphToMany(Media::class, 'mediable')
            ->wherePivot('type', '=', MediaType::VIDEO);
    }

    public function node()
    {
        return $this->belongsTo(Node::class, 'node_id', 'id');
    }
}
