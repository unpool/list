<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    // config
    protected $table = 'channels';
    protected $guarded = ['id'];
    protected $fillable = [
        'admin_id',
        'address_photo',
        'description',
        'title',
        'type',
        'created_at' ,
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'channel_user');
    }

}
