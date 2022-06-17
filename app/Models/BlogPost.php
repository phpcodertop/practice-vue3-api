<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = array('postImage');

    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getPostImageAttribute(): string
    {
        if (isset($this->attributes['image'])) {
            return asset($this->attributes['image']);
        }

        return asset('uploads/blog-default.png');
    }
}
