<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelFile extends Model
{
    // config
    protected $table = 'channel_files';
    protected $guarded = ['id'];
    protected $fillable = [
        'address',
        'file_type',
        'size',
        'channel_massage_id',
    ];

    public function channelMassage()
    {
        return $this->belongsTo(ChannelMassage::class, 'channel_massage_id', 'id');
    }
}
