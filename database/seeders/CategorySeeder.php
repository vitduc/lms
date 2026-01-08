<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lập trình', 'icon' => 'fa-code', 'description' => 'Khóa học về lập trình và phát triển phần mềm'],
            ['name' => 'Marketing', 'icon' => 'fa-bullhorn', 'description' => 'Digital Marketing, SEO, Content Marketing'],
            ['name' => 'Thiết kế', 'icon' => 'fa-palette', 'description' => 'UI/UX Design, Graphic Design, Web Design'],
            ['name' => 'Kinh doanh', 'icon' => 'fa-briefcase', 'description' => 'Quản trị kinh doanh, Khởi nghiệp'],
            ['name' => 'Nhiếp ảnh', 'icon' => 'fa-camera', 'description' => 'Nhiếp ảnh chuyên nghiệp, chỉnh sửa ảnh'],
            ['name' => 'Ngôn ngữ', 'icon' => 'fa-globe', 'description' => 'Học ngoại ngữ, giao tiếp'],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'order' => $index + 1,
            ]);
        }
    }
}
