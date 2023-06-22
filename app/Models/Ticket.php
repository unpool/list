<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function node()
    {
        return $this->belongsTo(Node::class, 'node_id', 'id');
    }

    public function answerToQuestion($answer)
    {
        return $this->update([
            'answer' => $answer,
            'admin_id' => auth_admin()->user()->id
        ]);
    }
}
