<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherGroup extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'group', 'teacher_id', 'created_at', 'updated_at'
    ];

    public function members()
    {
        return $this->hasMany(TeacherGroup::class, 'group', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
