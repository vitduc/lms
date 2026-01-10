<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'name_translations',
    ];

    protected $casts = [
        'name_translations' => 'array',
    ];

    /**
     * Get translated name
     */
    public function getTranslatedNameAttribute()
    {
        return $this->getTranslated('name', null, $this->attributes['name'] ?? null);
    }

    /**
     * Get courses at this level
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

