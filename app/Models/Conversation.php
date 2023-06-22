<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Conversation
 *
 * @property int $id
 * @property string $text
 * @property int $node_id
 * @property int $conversationable_id
 * @property string $conversationable_type
 * @property int $reply_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Conversation[] $conversationable
 * @property-read Node $node
 * @method static Builder|Conversation newModelQuery()
 * @method static Builder|Conversation newQuery()
 * @method static Builder|Conversation query()
 * @method static Builder|Conversation whereConversationableId($value)
 * @method static Builder|Conversation whereConversationableType($value)
 * @method static Builder|Conversation whereCreatedAt($value)
 * @method static Builder|Conversation whereId($value)
 * @method static Builder|Conversation whereNodeId($value)
 * @method static Builder|Conversation whereReplyId($value)
 * @method static Builder|Conversation whereText($value)
 * @method static Builder|Conversation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Conversation extends Model
{
    /**
     * @var string
     */
    protected $table = 'conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'text', 'group_conversation_id', 'conversationable_id', 'conversationable_type', 'reply_id', 'created_at', 'updated_at'
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

    public function groupConversations()
    {
        return $this->belongsTo(GroupConversation::class, 'group_conversation_id', 'id');
    }

    /**
     * @return MorphTo
     */
    public function conversationable()
    {
        return $this->morphTo();
    }
}
