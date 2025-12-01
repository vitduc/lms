<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles (check if they exist first)
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Full access to the system',
            ]
        );

        $instructorRole = Role::firstOrCreate(
            ['name' => 'instructor'],
            [
                'display_name' => 'Instructor',
                'description' => 'Can create and manage courses',
            ]
        );

        $studentRole = Role::firstOrCreate(
            ['name' => 'student'],
            [
                'display_name' => 'Student',
                'description' => 'Can enroll and take courses',
            ]
        );

        // Create Permissions
        $permissions = [
            // Course Permissions
            ['name' => 'create_course', 'display_name' => 'Create Course', 'module' => 'courses'],
            ['name' => 'edit_course', 'display_name' => 'Edit Course', 'module' => 'courses'],
            ['name' => 'delete_course', 'display_name' => 'Delete Course', 'module' => 'courses'],
            ['name' => 'view_course', 'display_name' => 'View Course', 'module' => 'courses'],
            ['name' => 'publish_course', 'display_name' => 'Publish Course', 'module' => 'courses'],

            // Lesson Permissions
            ['name' => 'create_lesson', 'display_name' => 'Create Lesson', 'module' => 'lessons'],
            ['name' => 'edit_lesson', 'display_name' => 'Edit Lesson', 'module' => 'lessons'],
            ['name' => 'delete_lesson', 'display_name' => 'Delete Lesson', 'module' => 'lessons'],

            // Quiz Permissions
            ['name' => 'create_quiz', 'display_name' => 'Create Quiz', 'module' => 'quizzes'],
            ['name' => 'edit_quiz', 'display_name' => 'Edit Quiz', 'module' => 'quizzes'],
            ['name' => 'delete_quiz', 'display_name' => 'Delete Quiz', 'module' => 'quizzes'],
            ['name' => 'grade_quiz', 'display_name' => 'Grade Quiz', 'module' => 'quizzes'],

            // Enrollment Permissions
            ['name' => 'enroll_course', 'display_name' => 'Enroll in Course', 'module' => 'enrollments'],
            ['name' => 'view_enrollment', 'display_name' => 'View Enrollment', 'module' => 'enrollments'],

            // Order Permissions
            ['name' => 'view_orders', 'display_name' => 'View Orders', 'module' => 'orders'],
            ['name' => 'manage_orders', 'display_name' => 'Manage Orders', 'module' => 'orders'],

            // User Permissions
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'module' => 'users'],
            ['name' => 'view_analytics', 'display_name' => 'View Analytics', 'module' => 'analytics'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Assign permissions to roles
        // Admin - All permissions
        $allPermissionIds = Permission::pluck('id')->toArray();
        foreach ($allPermissionIds as $permId) {
            $adminRole->permissions()->syncWithoutDetaching($permId);
        }

        // Instructor - Course, Lesson, Quiz, Enrollment permissions
        $instructorPermissions = Permission::whereIn('module', ['courses', 'lessons', 'quizzes', 'enrollments'])->pluck('id')->toArray();
        foreach ($instructorPermissions as $permId) {
            $instructorRole->permissions()->syncWithoutDetaching($permId);
        }

        // Student - View and Enroll permissions
        $studentPermissions = Permission::whereIn('name', ['view_course', 'enroll_course', 'view_enrollment'])->pluck('id')->toArray();
        foreach ($studentPermissions as $permId) {
            $studentRole->permissions()->syncWithoutDetaching($permId);
        }
    }
}
