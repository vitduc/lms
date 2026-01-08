<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::whereHas('roles', fn($q) => $q->where('name', 'student'))->get();
        $courses = Course::all();

        if ($students->isEmpty() || $courses->isEmpty()) {
            return;
        }

        $sampleReviews = [
            [
                'rating' => 5,
                'title' => 'Khóa học tuyệt vời!',
                'content' => 'Nội dung rất chi tiết, giảng viên giải thích dễ hiểu. Mình đã áp dụng được ngay vào công việc.',
            ],
            [
                'rating' => 4,
                'title' => 'Rất hữu ích',
                'content' => 'Khóa học mang lại nhiều kiến thức thực tế, chỉ cần thêm vài ví dụ nâng cao nữa là hoàn hảo.',
            ],
            [
                'rating' => 5,
                'title' => 'Giảng viên nhiệt tình',
                'content' => 'Giảng viên trả lời câu hỏi rất nhanh và tận tâm, mình cảm thấy được hỗ trợ rất tốt.',
            ],
            [
                'rating' => 3,
                'title' => 'Ổn, nhưng có thể tốt hơn',
                'content' => 'Một số phần hơi nhanh, nếu có thêm bài tập thực hành thì sẽ dễ hiểu hơn.',
            ],
        ];

        foreach ($courses as $course) {
            foreach ($students->take(3) as $index => $student) {
                $template = $sampleReviews[$index % count($sampleReviews)];

                Review::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'rating' => $template['rating'],
                        'title' => $template['title'],
                        'content' => $template['content'],
                        'is_verified_purchase' => true,
                        'helpful_count' => rand(0, 20),
                        'status' => 'approved',
                    ]
                );
            }
        }
    }
}