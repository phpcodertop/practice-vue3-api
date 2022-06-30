<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Gallery extends Model
{
    use HasFactory;
    protected $table = 'gallery_images';
    protected $guarded = [];
    protected $appends = ['fullPath'];

    public  function getFullPathAttribute()
    {
        return asset($this->attributes['path']);
    }
}
