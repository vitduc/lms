@extends('layouts.app')

@section('content')
@php
    $enrolledCourses = [
        [
            'title' => 'Lập trình Laravel từ A-Z',
            'progress' => 72,
            'instructor' => 'Nguyễn Văn A',
            'chapters' => 48,
            'completed_chapters' => 34,
            'cover' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=280&fit=crop'
        ],
        [
            'title' => 'UI/UX Design Fundamentals',
            'progress' => 45,
            'instructor' => 'Lê Thị B',
            'chapters' => 36,
            'completed_chapters' => 16,
            'cover' => 'https://images.unsplash.com/photo-1556514767-5c270b96a005?w=400&h=280&fit=crop'
        ],
        [
            'title' => 'Digital Marketing 360°',
            'progress' => 18,
            'instructor' => 'Trần Quang C',
            'chapters' => 30,
            'completed_chapters' => 5,
            'cover' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=400&h=280&fit=crop'
        ],
    ];
@endphp

<section class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Learning Hub</p>
                <h1 class="text-4xl font-bold text-gray-900">Khóa học của tôi</h1>
                <p class="text-gray-500 mt-2">Theo dõi tiến độ học tập và quay lại những bài học gần nhất.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button class="btn-primary text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2">
                    <i class="fas fa-play-circle"></i> Tiếp tục học
                </button>
                <button class="border border-gray-300 px-6 py-3 rounded-xl font-semibold text-gray-700 hover:bg-gray-50">
                    Sắp xếp
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <button class="px-4 py-2 rounded-full bg-purple-100 text-purple-600 font-semibold text-sm">Tất cả</button>
                <button class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-semibold text-sm">Đang học</button>
                <button class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-semibold text-sm">Hoàn thành</button>
                <button class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-semibold text-sm">Đã lưu</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach ($enrolledCourses as $course)
                    <div class="border border-gray-100 rounded-2xl overflow-hidden flex flex-col">
                        <div class="h-44 relative">
                            <img src="{{ $course['cover'] }}" alt="{{ $course['title'] }}" class="w-full h-full object-cover">
                            <span class="absolute top-4 left-4 bg-white/90 text-gray-800 text-xs font-bold px-3 py-1 rounded-full shadow">
                                {{ $course['completed_chapters'] }}/{{ $course['chapters'] }} chương
                            </span>
                        </div>
                        <div class="flex-1 p-5 flex flex-col gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $course['title'] }}</h3>
                                <p class="text-sm text-gray-500">GV: {{ $course['instructor'] }}</p>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-600">Tiến độ</span>
                                    <span class="font-semibold text-purple-600">{{ $course['progress'] }}%</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 rounded-full">
                                    <div class="h-full bg-gradient-to-r from-purple-500 to-blue-500 rounded-full"
                                         style="width: {{ $course['progress'] }}%"></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <button class="text-purple-600 font-semibold flex items-center gap-2 hover:text-purple-700">
                                    <i class="fas fa-play"></i> Tiếp tục
                                </button>
                                <button class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Tiếp tục học</p>
                    <h2 class="text-2xl font-bold text-gray-900">Bài học gần đây</h2>
                </div>
                <a href="#" class="text-purple-600 font-semibold hover:text-purple-700 text-sm">Xem tất cả</a>
            </div>
            <div class="space-y-4">
                @foreach ($enrolledCourses as $course)
                    <div class="p-4 border border-gray-100 rounded-2xl flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                            <i class="fas fa-book-reader text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">{{ $course['title'] }}</p>
                            <p class="font-semibold text-gray-900">Chương {{ min($course['completed_chapters'] + 1, $course['chapters']) }}: Bài học mới</p>
                        </div>
                        <button class="px-5 py-2 rounded-full border border-purple-200 text-purple-600 text-sm font-semibold">
                            Tiếp tục
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

