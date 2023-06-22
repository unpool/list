<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property mixed is_special
 */
class Plan extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'score',
        'period',
        'price',
        'share_invited',
        'category',
        'is_special',
    ];

    /**
     * @return string
     */
    public function getSpecialAttribute():String
    {
        return $this->is_special ? "check" : "times";
    }

    /**
     * @return MorphMany
     */
    public function orderable()
    {
        return $this->morphMany(Orderable::class, 'nodeable');
    }
}
