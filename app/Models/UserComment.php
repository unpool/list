<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    protected $fillable = ['title','body','file','file_type'];
}
