<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;

// Language switching route (no locale prefix)
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Redirect root to default locale
Route::get('/', function () {
    $locale = session('locale', config('app.locale', 'en'));
    return redirect('/' . $locale);
});

// Routes with locale prefix
Route::prefix('{locale}')->where(['locale' => 'en|vi'])->group(function () {
    // Home Routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
    Route::get('/instructors', [HomeController::class, 'instructors'])->name('instructors');
    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');

    // Course Routes
    Route::get('/courses/{slug?}', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/view/{slug}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll')->middleware('auth');
    Route::get('/courses/{id}/payment', [CourseController::class, 'payment'])->name('courses.payment')->middleware('auth');
    Route::post('/courses/{id}/payment', [CourseController::class, 'processPayment'])->name('courses.payment.process')->middleware('auth');

    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store')->middleware('guest');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store')->middleware('guest');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Authenticated user routes
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::patch('/profile/two-factor', [ProfileController::class, 'toggleTwoFactor'])->name('profile.two-factor');
        Route::view('/my-courses', 'pages.my-courses')->name('my-courses');
        Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
        Route::view('/settings', 'pages.settings')->name('settings');
        Route::view('/teach', 'pages.teach')->name('teach');

        // Notifications routes
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
        Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
    });

    // Two-Factor Authentication routes
    Route::get('/2fa', [TwoFactorController::class, 'show'])->name('2fa.show');
    Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');
    Route::post('/2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');
});

// Admin Auth Routes (no locale prefix)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AdminAuthController::class, 'storeLogin'])->name('login.store')->middleware('guest');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Admin Routes (no locale prefix)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('users', AdminUserController::class)->except(['create', 'store', 'destroy', 'show']);
});
