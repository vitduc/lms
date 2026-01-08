<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Cơ bản', 'slug' => 'beginner'],
            ['name' => 'Trung bình', 'slug' => 'intermediate'],
            ['name' => 'Nâng cao', 'slug' => 'advanced'],
        ];

        foreach ($levels as $index => $level) {
            Level::create([
                'name' => $level['name'],
                'slug' => $level['slug'],
                'order' => $index + 1,
            ]);
        }
    }
}
