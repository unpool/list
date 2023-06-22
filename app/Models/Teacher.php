<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conversation[] $conversations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Teacher extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * @var string
     */
    protected $guard_name = 'teacher';


    /**
     * @var string
     */
    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 'password', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @var bool
     */
    public $timestamps = true;

    public function fullName()
    {
        return "$this->first_name $this->last_name";
    }

    // ------------ RELATION ------------  
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function conversations()
    {
        return $this->morphMany(Conversation::class, 'conversationable');
    }

    /**
     * @return HasOne
     */
    public function cv(): HasOne
    {
        return $this->hasOne(TeacherCV::class);
    }

    public function products()
    {
        return $this->morphMany(Node::class, 'ownerable', 'ownerable_type', 'ownerable_id');
    }

    public function nodePermissionable()
    {
        return $this->morphToMany(
            \App\Models\Node::class,
            'model',
            'model_node_permissions',
            'model_id',
            'node_id'
        );
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(TeacherGroup::class);
    }
}
