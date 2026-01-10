<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
        'name_translations',
        'description_translations',
    ];

    protected $casts = [
        'name_translations' => 'array',
        'description_translations' => 'array',
    ];

    /**
     * Get translated name
     */
    public function getTranslatedNameAttribute()
    {
        return $this->getTranslated('name', null, $this->attributes['name'] ?? null);
    }

    /**
     * Get translated description
     */
    public function getTranslatedDescriptionAttribute()
    {
        return $this->getTranslated('description', null, $this->attributes['description'] ?? null);
    }

    /**
     * Get courses in this category
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_category');
    }
}

