<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'students' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count(),
            'instructors' => User::whereHas('roles', fn ($q) => $q->where('name', 'instructor'))->count(),
            'courses' => Course::count(),
            'activeEnrollments' => CourseEnrollment::count(),
        ];

        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'latestUsers' => $latestUsers,
        ]);
    }
}

