<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run role seeder first
        $this->call(RoleSeeder::class);

        // Create test users
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->roles()->attach(1); // Admin role

        $instructor = User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
        ]);
        $instructor->roles()->attach(2); // Instructor role

        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
        ]);
        $student->roles()->attach(3); // Student role
    }
}
