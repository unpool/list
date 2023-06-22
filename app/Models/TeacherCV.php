<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherCV extends Model
{
    public $table = 'teacher_cv';
    public $fillable = ['cv', 'teacher_id'];

    /**
     * @return BelongsTo
     */
    public function teacher():BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
