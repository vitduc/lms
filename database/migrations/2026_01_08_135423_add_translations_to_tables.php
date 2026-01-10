<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Courses table - convert title, description, content to JSON
        Schema::table('courses', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('description_translations')->nullable()->after('description');
            $table->json('content_translations')->nullable()->after('content');
        });

        // Migrate existing data to JSON format
        $courses = DB::table('courses')->get();
        foreach ($courses as $course) {
            $updates = [
                'title_translations' => json_encode(['en' => $course->title, 'vi' => $course->title]),
            ];
            if ($course->description) {
                $updates['description_translations'] = json_encode(['en' => $course->description, 'vi' => $course->description]);
            }
            if ($course->content) {
                $updates['content_translations'] = json_encode(['en' => $course->content, 'vi' => $course->content]);
            }
            DB::table('courses')->where('id', $course->id)->update($updates);
        }

        // Categories table - convert name, description to JSON
        Schema::table('categories', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
            $table->json('description_translations')->nullable()->after('description');
        });

        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $updates = [
                'name_translations' => json_encode(['en' => $category->name, 'vi' => $category->name]),
            ];
            if ($category->description) {
                $updates['description_translations'] = json_encode(['en' => $category->description, 'vi' => $category->description]);
            }
            DB::table('categories')->where('id', $category->id)->update($updates);
        }

        // Levels table - convert name to JSON
        Schema::table('levels', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
        });

        $levels = DB::table('levels')->get();
        foreach ($levels as $level) {
            DB::table('levels')->where('id', $level->id)->update([
                'name_translations' => json_encode(['en' => $level->name, 'vi' => $level->name]),
            ]);
        }

        // Sections table - convert title, description to JSON
        Schema::table('sections', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('description_translations')->nullable()->after('description');
        });

        $sections = DB::table('sections')->get();
        foreach ($sections as $section) {
            $updates = [
                'title_translations' => json_encode(['en' => $section->title, 'vi' => $section->title]),
            ];
            if ($section->description) {
                $updates['description_translations'] = json_encode(['en' => $section->description, 'vi' => $section->description]);
            }
            DB::table('sections')->where('id', $section->id)->update($updates);
        }

        // Lessons table - convert title, description, content to JSON
        Schema::table('lessons', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('description_translations')->nullable()->after('description');
            $table->json('content_translations')->nullable()->after('content');
        });

        $lessons = DB::table('lessons')->get();
        foreach ($lessons as $lesson) {
            $updates = [
                'title_translations' => json_encode(['en' => $lesson->title, 'vi' => $lesson->title]),
            ];
            if ($lesson->description) {
                $updates['description_translations'] = json_encode(['en' => $lesson->description, 'vi' => $lesson->description]);
            }
            if ($lesson->content) {
                $updates['content_translations'] = json_encode(['en' => $lesson->content, 'vi' => $lesson->content]);
            }
            DB::table('lessons')->where('id', $lesson->id)->update($updates);
        }

        // Announcements table - convert title, content to JSON
        Schema::table('announcements', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('content_translations')->nullable()->after('content');
        });

        $announcements = DB::table('announcements')->get();
        foreach ($announcements as $announcement) {
            DB::table('announcements')->where('id', $announcement->id)->update([
                'title_translations' => json_encode(['en' => $announcement->title, 'vi' => $announcement->title]),
                'content_translations' => json_encode(['en' => $announcement->content, 'vi' => $announcement->content]),
            ]);
        }

        // Reviews table - convert title, content to JSON
        Schema::table('reviews', function (Blueprint $table) {
            $table->json('title_translations')->nullable()->after('title');
            $table->json('content_translations')->nullable()->after('content');
        });

        $reviews = DB::table('reviews')->get();
        foreach ($reviews as $review) {
            $updates = [];
            if ($review->title) {
                $updates['title_translations'] = json_encode(['en' => $review->title, 'vi' => $review->title]);
            }
            if ($review->content) {
                $updates['content_translations'] = json_encode(['en' => $review->content, 'vi' => $review->content]);
            }
            if (!empty($updates)) {
                DB::table('reviews')->where('id', $review->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'description_translations', 'content_translations']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_translations', 'description_translations']);
        });

        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('name_translations');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'description_translations']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'description_translations', 'content_translations']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'content_translations']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['title_translations', 'content_translations']);
        });
    }
};
