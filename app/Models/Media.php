<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $size byte of file
 * @property string $path
 * @property string $duration
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\Node[] $nodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Slider[] $sliders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media withoutTrashed()
 * @mixin \Eloquent
 */
class Media extends Model
{
    const MAX_ORDER = 1;
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'size', 'path', 'duration', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

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

    public function getTypeOfFile(\Illuminate\Http\UploadedFile $file)
    {
        $mime = $file->getMimeType();
        if (strstr($mime, "video/")) {
            return strtolower(\App\Enums\MediaType::getKey(\App\Enums\MediaType::VIDEO));
        } else if (strstr($mime, "image/")) {
            return strtolower(\App\Enums\MediaType::getKey(\App\Enums\MediaType::IMAGE));
        } else if ($mime === 'application/pdf') {
            return strtolower(\App\Enums\MediaType::getKey(\App\Enums\MediaType::PDF));
        } else if (in_array($mime, array_values($this->officeMimeType()))) {
            return 'office';
        } else if (strstr($mime, 'audio/')) {
            return strtolower(\App\Enums\MediaType::getKey(\App\Enums\MediaType::VOICE));
        } else {
            return 'unknown';
        }
    }

    /**
     * @return array 
     */
    public static function officeMimeType(): array
    {
        return array(
            'doc' => 'application/msword',
            'dot' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
            'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
            'xls' => 'application/vnd.ms-excel',
            'xlt' => 'application/vnd.ms-excel',
            'xla' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
            'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pot' => 'application/vnd.ms-powerpoint',
            'pps' => 'application/vnd.ms-powerpoint',
            'ppa' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
            'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'mediable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function nodes()
    {
        return $this->morphedByMany(Node::class, 'mediable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sliders()
    {
        return $this->morphedByMany(Slider::class, 'mediable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'mediable');
    }

    public function mediable()
    {
        return $this->hasMany(Mediable::class, 'media_id');
    }
}
