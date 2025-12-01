<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Courses table
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Instructor
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('level_id')->constrained('levels')->onDelete('restrict');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('status')->default('draft'); // draft, published, archived
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('user_id');
        });

        // Sections table
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->index('course_id');
        });

        // Lessons table
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->string('document_url')->nullable();
            $table->integer('duration')->nullable(); // in minutes
            $table->integer('order')->default(0);
            $table->string('status')->default('draft');
            $table->boolean('is_free')->default(false);
            $table->timestamps();

            $table->index('section_id');
        });

        // Course enrollments
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('status')->default('active'); // active, completed, dropped
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamp('enrolled_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index('status');
        });

        // Lesson progress
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('watched_at')->nullable();
            $table->integer('watch_time')->default(0); // in seconds
            $table->integer('total_time')->default(0); // in seconds
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
            $table->index('is_completed');
        });

        // Announcements
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Instructor
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('general'); // general, update, reminder, important
            $table->boolean('is_pinned')->default(false);
            $table->string('status')->default('published'); // draft, published, archived
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('course_id');
            $table->index('type');
            $table->index('is_pinned');
        });

        // Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->integer('rating')->default(5); // 1-5 stars
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->boolean('is_verified_purchase')->default(true);
            $table->integer('helpful_count')->default(0);
            $table->string('status')->default('approved'); // pending, approved, rejected
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index('rating');
            $table->index('status');
        });

        // Certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('status')->default('issued'); // issued, revoked
            $table->timestamp('issued_at');
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index('certificate_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('course_enrollments');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('courses');
    }
};
