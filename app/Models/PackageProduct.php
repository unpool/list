<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['package_id', 'product_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(PackageProduct::class, 'package_id');
    }

    public function package()
    {
        return $this->belongsTo(Node::class, 'package_id');
    }
}
