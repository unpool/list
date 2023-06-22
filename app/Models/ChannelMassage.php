<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelMassage extends Model
{
    // config
    protected $table = 'channel_massages';
    protected $guarded = ['id'];
    protected $fillable = [
        'body',
        'admin_id',
        'channel_id',
        'is_file',
    ];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function fileMassage()
    {
        return $this->hasOne(ChannelFile::class, 'channel_massage_id', 'id');
    }
}
