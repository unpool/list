<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'description',
        'user_id',
        'node_id'
    ];

    public function user()
    {
        return $this->belongsTo(Note::class);
    }

    public function node()
    {
        return $this->belongsTo(Node::class);
    }
}
