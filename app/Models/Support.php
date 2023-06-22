<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

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
class Support extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * @var string
     */
    //protected $guard_name = 'support';


    /**
     * @var string
     */
    protected $table = 'supports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'parent_id', 'seen', 'type', 'title', 'message', 'created_at', 'updated_at'
    ];
    public $appends = ['j_fullname'];

    public function getJfullNameAttribute()
    {
        $user = DB::table('users')->where('id', $this->user_id)->first();
        return @$user->first_name .' '. @$user->last_name;
    }

    public $timestamps = true;



}