<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'user_id',
        'category_id',
        'level_id',
        'title',
        'slug',
        'description',
        'content',
        'thumbnail',
        'price',
        'status',
        'order',
        'title_translations',
        'description_translations',
        'content_translations',
    ];

    protected $casts = [
        'title_translations' => 'array',
        'description_translations' => 'array',
        'content_translations' => 'array',
    ];

    /**
     * Get translated title
     */
    public function getTranslatedTitleAttribute()
    {
        return $this->getTranslated('title', null, $this->attributes['title'] ?? null);
    }

    /**
     * Get translated description
     */
    public function getTranslatedDescriptionAttribute()
    {
        return $this->getTranslated('description', null, $this->attributes['description'] ?? null);
    }

    /**
     * Get translated content
     */
    public function getTranslatedContentAttribute()
    {
        return $this->getTranslated('content', null, $this->attributes['content'] ?? null);
    }

    /**
     * Get the instructor (user) that owns the course.
     *
     * @return BelongsTo
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the categories of the course.
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_course');
    }

    /**
     * Get the first category of the course (for backward compatibility).
     *
     * @return Category|null
     */
    public function getCategoryAttribute()
    {
        return $this->categories()->first();
    }

    /**
     * Get the level of the course.
     *
     * @return BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get enrollments for this course.
     *
     * @return HasMany
     */
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    /**
     * Get approved reviews for this course.
     *
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    /**
     * Check if course is free
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }

    /**
     * Check if user is enrolled
     *
     * @param $userId
     * @return bool
     */
    public function isEnrolledBy($userId): bool
    {
        return $this->enrollments()->where('user_id', $userId)->exists();
    }
}

