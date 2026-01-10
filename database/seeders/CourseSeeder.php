<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Get first user as instructor (or create one)
        $instructor = User::first();
        if (!$instructor) {
            $instructor = User::create([
                'name' => 'Giảng viên Mẫu',
                'email' => 'instructor@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $levels = Level::all();

        $courses = [
            [
                'title' => 'Lập trình Laravel từ A-Z',
                'description' => 'Khóa học Laravel toàn diện từ cơ bản đến nâng cao, học cách xây dựng ứng dụng web hiện đại với PHP framework mạnh mẽ nhất.',
                'price' => 599000,
                'level' => 'Cơ bản',
                'thumbnail' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'UI/UX Design Fundamentals',
                'description' => 'Học thiết kế giao diện người dùng chuyên nghiệp, từ wireframe đến prototype hoàn chỉnh.',
                'price' => 699000,
                'level' => 'Trung bình',
                'thumbnail' => 'https://images.unsplash.com/photo-1558655146-364adaf1fcc9?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Digital Marketing Mastery',
                'description' => 'Chiến lược marketing số hiệu quả, SEO, Google Ads, Facebook Ads và Content Marketing.',
                'price' => 799000,
                'level' => 'Trung bình',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Python cho người mới bắt đầu',
                'description' => 'Khóa học Python từ zero đến hero, học lập trình với ngôn ngữ đơn giản và mạnh mẽ.',
                'price' => 0, // Free course
                'level' => 'Cơ bản',
                'thumbnail' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'React Advanced Patterns',
                'description' => 'Nâng cao kỹ năng React với hooks, context API, performance optimization và testing.',
                'price' => 899000,
                'level' => 'Nâng cao',
                'thumbnail' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Nhiếp ảnh chuyên nghiệp',
                'description' => 'Học cách chụp ảnh đẹp, chỉnh sửa với Lightroom và Photoshop.',
                'price' => 499000,
                'level' => 'Trung bình',
                'thumbnail' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Khởi nghiệp từ A-Z',
                'description' => 'Học cách khởi nghiệp thành công, từ ý tưởng đến thực thi và mở rộng.',
                'price' => 999000,
                'level' => 'Nâng cao',
                'thumbnail' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=800&h=600&fit=crop',
            ],
            [
                'title' => 'Tiếng Anh giao tiếp cơ bản',
                'description' => 'Học tiếng Anh giao tiếp hàng ngày, từ vựng và ngữ pháp cơ bản.',
                'price' => 0, // Free course
                'level' => 'Cơ bản',
                'thumbnail' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=600&fit=crop',
            ],
        ];

        foreach ($courses as $courseData) {
            $level = $levels->where('name', $courseData['level'])->first();

            Course::create([
                'user_id' => $instructor->id,
                'level_id' => $level->id,
                'title' => $courseData['title'],
                'slug' => Str::slug($courseData['title']),
                'description' => $courseData['description'],
                'content' => '<p>' . $courseData['description'] . '</p>',
                'thumbnail' => $courseData['thumbnail'],
                'price' => $courseData['price'],
                'status' => 'published',
                'order' => 0,
            ]);
        }
    }
}
