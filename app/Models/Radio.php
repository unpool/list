<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $fillable = [
        'title','description','file' , 'admin_id'
    ];
}
