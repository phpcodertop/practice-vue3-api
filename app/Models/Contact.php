<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    public function getImageAttribute(): ?string
    {
        if (isset($this->attributes['image']))
        {
            return asset($this->attributes['image']);
        }
        return null;
    }

    public function getOriginalImageAttribute()
    {
        return $this->attributes['image'] ?? null;
    }

}
