<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class GroupConversation
 * @package App\Models
 */
class GroupConversation extends Model
{

    /**
     * @var string
     */
    protected $table = 'group_conversation';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'node_id', 'is_public'
    ];


    /**
     * @return BelongsTo
     */
    public function node()
    {
        return $this->belongsTo(Node::class, 'node_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'group_conversation_id', 'id');
    }
}
