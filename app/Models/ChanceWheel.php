<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChanceWheel extends Model
{
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
