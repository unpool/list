<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\GroupConversation;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class ConversationRepository extends BaseRepository implements ConversationRepositoryImp
{

    public $group_conversation;
    public $user;

    /**
     * ConversationRepository constructor.
     * @param Conversation $model
     * @param GroupConversation $group_conversation
     * @param UserRepository $user
     */
    public function __construct(Conversation $model, GroupConversation $group_conversation, UserRepository $user)
    {
        parent::__construct($model);
        $this->group_conversation = $group_conversation;
        $this->user = $user;
    }

    public function create(array $attributes): Model
    {
        DB::beginTransaction();
        try {
            $group_conversation = $this->group_conversation->where(['node_id' => $attributes['node_id'], 'is_public' => $attributes['is_public']])->first();
            if ($attributes['is_public'] == 0) {  //for private conversation
                $group_conversation = $this->group_conversation::whereHas('conversations', function ($query) use ($attributes) {
                    $query->where('conversationable_type', '=', User::class);
                    $query->where('conversationable_id', '=', $attributes['user_id']);
                })->where(['node_id' => $attributes['node_id'], 'is_public' => $attributes['is_public']])->first();
            }
            if (empty($group_conversation)) {
                $group_conversation = $this->group_conversation->create($attributes);
            }
            $group_conversation->conversations()->create($attributes);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return $group_conversation->conversations()->latest()->first();
    }
}
