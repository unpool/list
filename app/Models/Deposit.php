<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';

    protected $fillable = [
        'admin_id',
        'user_id',
        'price',
        'card_number',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
