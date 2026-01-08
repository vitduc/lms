<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'order',
    ];

    /**
     * Get courses at this level
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

