<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

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
    ];

    /**
     * Get the instructor (user) that owns the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category of the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }
}

