<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',
        'bio',
        'phone',
        'country',
        'city',
        'profession',
        'social_links',
        'is_instructor',
        'instructor_bio',
        'instructor_title',
        'total_students',
        'average_rating',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_instructor' => 'boolean',
        'total_students' => 'integer',
        'average_rating' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

