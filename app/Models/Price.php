<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Price
 *
 * @property int $id
 * @property int $node_id
 * @property string $type
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Price extends Model
{
    /**
     * @var string
     */
    protected $table = 'prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'node_id', 'type', 'amount', 'off_percent', 'created_at', 'updated_at'
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
    public function node()
    {
        return $this->belongsTo(Node::class, 'node_id', 'id');
    }
}
