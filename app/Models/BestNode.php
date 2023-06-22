<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BestNode
 *
 * @property int $id
 * @property int $node_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BestNode extends Model
{
    /**
     * @var string
     */
    protected $table = 'best_nodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'node_id', 'created_at', 'updated_at'
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
    public function node() {

        return $this->belongsTo(Node::class, 'node_id', 'id');
    }
}
