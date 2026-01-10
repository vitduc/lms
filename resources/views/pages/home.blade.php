@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="pt-20 pb-32 bg-gradient-to-r from-purple-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    {{ __('Learn anytime, anywhere') }}
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    {{ __('Online learning platform that gives you access to thousands of quality courses from world-class instructors.') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ localized_route('courses.index') }}" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold text-center">
                        <i class="fas fa-book mr-2"></i>{{ __('Explore courses') }}
                    </a>
                    <a href="{{ localized_route('register') }}" class="border-2 border-purple-600 text-purple-600 hover:bg-purple-50 px-8 py-3 rounded-lg font-semibold text-center transition">
                        <i class="fas fa-user-plus mr-2"></i>{{ __('Sign up for free') }}
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-blue-400 rounded-lg blur-3xl opacity-20"></div>
                    <svg class="relative" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                        <rect width="400" height="400" fill="none"/>
                        <circle cx="200" cy="150" r="80" fill="#667eea" opacity="0.1"/>
                        <path d="M 100 250 Q 200 200 300 250" stroke="#667eea" stroke-width="3" fill="none" opacity="0.3"/>
                        <rect x="150" y="300" width="100" height="80" fill="#764ba2" opacity="0.1" rx="10"/>
                        <circle cx="80" cy="300" r="30" fill="#667eea" opacity="0.2"/>
                        <circle cx="320" cy="280" r="40" fill="#764ba2" opacity="0.15"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Bar -->
<section class="relative -mt-16 mb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <form class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                    <input
                        type="text"
                        placeholder="{{ __('Search for courses...') }}"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                    >
                </div>
                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                    <option>{{ __('All categories') }}</option>
                    <option>Lập trình</option>
                    <option>Marketing</option>
                    <option>Thiết kế</option>
                    <option>Kinh doanh</option>
                </select>
                <button type="submit" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold">
                    {{ __('Search') }}
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                {{ __('Featured categories') }}
            </h2>
            <p class="text-gray-600">{{ __('Explore thousands of courses in different categories') }}</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $categories = [
                    ['icon' => 'fa-code', 'name' => 'Lập trình', 'count' => '250+'],
                    ['icon' => 'fa-bullhorn', 'name' => 'Marketing', 'count' => '180+'],
                    ['icon' => 'fa-palette', 'name' => 'Thiết kế', 'count' => '150+'],
                    ['icon' => 'fa-briefcase', 'name' => 'Kinh doanh', 'count' => '120+'],
                    ['icon' => 'fa-camera', 'name' => 'Nhiếp ảnh', 'count' => '80+'],
                    ['icon' => 'fa-globe', 'name' => 'Ngôn ngữ', 'count' => '200+'],
                ];
            @endphp

            @foreach ($categories as $category)
                <a href="{{ localized_url('categories/' . strtolower($category['name'])) }}" class="card-hover group">
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-lg p-6 text-center hover:from-purple-100 hover:to-blue-100 transition">
                        <i class="fas {{ $category['icon'] }} text-3xl text-purple-600 mb-3 group-hover:scale-110 transition transform"></i>
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $category['name'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $category['count'] }} {{ __('courses') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    {{ __('Featured courses') }}
                </h2>
                <p class="text-gray-600">{{ __('Highest rated courses by students') }}</p>
            </div>
            <a href="{{ localized_route('courses.index') }}" class="text-purple-600 font-semibold hover:text-purple-700">
                {{ __('View all') }} <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Swiper Carousel -->
        <div class="swiper mb-8">
            <div class="swiper-wrapper">
                @php
                    $courses = [
                        [
                            'id' => 1,
                            'title' => 'Web Development với Laravel',
                            'instructor' => 'Nguyễn Văn A',
                            'rating' => 4.8,
                            'students' => 1250,
                            'price' => '599.000',
                            'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Digital Marketing Mastery',
                            'instructor' => 'Trần Thị B',
                            'rating' => 4.7,
                            'students' => 980,
                            'price' => '799.000',
                            'image' => 'https://images.unsplash.com/photo-1460925895917-adf4198c838f?w=400&h=300&fit=crop'
                        ],
                        [
                            'id' => 3,
                            'title' => 'UI/UX Design Fundamentals',
                            'instructor' => 'Lê Văn C',
                            'rating' => 4.9,
                            'students' => 1520,
                            'price' => '699.000',
                            'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=300&fit=crop'
                        ],
                        [
                            'id' => 4,
                            'title' => 'Python für Anfänger',
                            'instructor' => 'Phạm Đức D',
                            'rating' => 4.6,
                            'students' => 2100,
                            'price' => '499.000',
                            'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop'
                        ],
                    ];
                @endphp

                @foreach ($courses as $course)
                    <div class="swiper-slide">
                        <div class="card-hover bg-white rounded-lg overflow-hidden shadow-md">
                            <!-- Course Image -->
                            <div class="relative overflow-hidden h-48">
                                <img src="{{ $course['image'] }}" alt="{{ $course['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition transform">
                                <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Sale
                                </div>
                            </div>

                            <!-- Course Content -->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $course['title'] }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $course['instructor'] }}</p>

                                <!-- Rating -->
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < floor($course['rating']))
                                                <i class="fas fa-star text-xs"></i>
                                            @else
                                                <i class="fas fa-star-half-alt text-xs"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600">({{ $course['students'] }})</span>
                                </div>

                                <!-- Price -->
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-purple-600">₫{{ $course['price'] }}</span>
                                    <a href="{{ localized_url('course/' . $course['id']) }}" class="text-purple-600 hover:text-purple-700">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev !text-purple-600"></div>
            <div class="swiper-button-next !text-purple-600"></div>
        </div>

        <div class="text-center">
            <a href="{{ localized_route('courses.index') }}" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold inline-block">
                {{ __('View all courses') }}
            </a>
        </div>
    </div>
</section>

<!-- Learning Stats -->
<section class="py-16 bg-gradient-to-r from-purple-600 to-blue-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">10,000+</div>
                <p class="text-purple-100"><i class="fas fa-graduation-cap mr-2"></i>{{ __('Students') }}</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">1,200+</div>
                <p class="text-purple-100"><i class="fas fa-book mr-2"></i>{{ __('Courses') }}</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">150+</div>
                <p class="text-purple-100"><i class="fas fa-chalkboard-user mr-2"></i>{{ __('Instructors') }}</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">98%</div>
                <p class="text-purple-100"><i class="fas fa-star mr-2"></i>{{ __('Satisfied') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Instructors -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                {{ __('Featured instructors') }}
            </h2>
            <p class="text-gray-600">{{ __('Learn from industry-leading experts') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $instructors = [
                    ['name' => 'Nguyễn Văn A', 'expertise' => 'Web Development', 'students' => 5200, 'courses' => 12],
                    ['name' => 'Trần Thị B', 'expertise' => 'Digital Marketing', 'students' => 3800, 'courses' => 8],
                    ['name' => 'Lê Văn C', 'expertise' => 'UI/UX Design', 'students' => 4100, 'courses' => 10],
                    ['name' => 'Phạm Đức D', 'expertise' => 'Python & AI', 'students' => 6200, 'courses' => 15],
                ];
            @endphp

            @foreach ($instructors as $instructor)
                <div class="card-hover bg-gray-50 rounded-lg p-6 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($instructor['name']) }}&size=80&background=667eea&color=fff"
                         alt="{{ $instructor['name'] }}" class="w-20 h-20 rounded-full mx-auto mb-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $instructor['name'] }}</h3>
                    <p class="text-purple-600 text-sm font-semibold mb-3">{{ $instructor['expertise'] }}</p>
                    <div class="flex justify-center gap-4 text-sm text-gray-600 mb-4">
                        <span><i class="fas fa-users mr-1"></i>{{ $instructor['students'] }}</span>
                        <span><i class="fas fa-book mr-1"></i>{{ $instructor['courses'] }}</span>
                    </div>
                    <a href="{{ localized_url('instructor/' . strtolower(str_replace(' ', '-', $instructor['name']))) }}" class="btn-primary text-white px-4 py-2 rounded-lg text-sm font-semibold inline-block">
                        {{ __('View Profile') }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                {{ __('Why choose LearnHub') }}
            </h2>
            <p class="text-gray-600">{{ __('Features that help you learn effectively') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    ['icon' => 'fa-mobile', 'title' => __('Learn anytime, anywhere'), 'desc' => __('Learn anytime, anywhere')],
                    ['icon' => 'fa-video', 'title' => __('High quality videos'), 'desc' => __('4K content with clear teaching')],
                    ['icon' => 'fa-check-circle', 'title' => __('Exercises & Tests'), 'desc' => __('Practice with hundreds of hands-on exercises')],
                    ['icon' => 'fa-certificate', 'title' => __('Completion certificate'), 'desc' => __('Widely recognized certificate')],
                    ['icon' => 'fa-credit-card', 'title' => __('Simple payment'), 'desc' => __('Support for multiple secure payment methods')],
                    ['icon' => 'fa-headset', 'title' => __('Support 24/7'), 'desc' => __('Support team always ready to help you')],
                ];
            @endphp

            @foreach ($features as $feature)
                <div class="card-hover bg-white rounded-lg p-8 text-center shadow-md">
                    <div class="text-4xl text-purple-600 mb-4 inline-block">
                        <i class="fas {{ $feature['icon'] }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                {{ __('Testimonials from students') }}
            </h2>
            <p class="text-gray-600">{{ __('Reviews from real students') }}</p>
        </div>

        <div class="swiper">
            <div class="swiper-wrapper">
                @php
                    $testimonials = [
                        ['name' => 'Trần Minh Quân', 'role' => 'Lập trình viên', 'text' => 'LearnHub giúp tôi nâng cao kỹ năng lập trình một cách hiệu quả. Nội dung rất chi tiết và dễ hiểu.', 'rating' => 5],
                        ['name' => 'Nguyễn Thúy Linh', 'role' => 'Digital Marketer', 'text' => 'Tôi đã hoàn thành 3 khóa học trên LearnHub. Chất lượng giảng dạy xuất sắc!', 'rating' => 5],
                        ['name' => 'Lê Công Dũng', 'role' => 'Designer', 'text' => 'Khóa học UI/UX Design rất hữu ích. Giảng viên rất tận tâm và giải đáp tất cả câu hỏi.', 'rating' => 4.8],
                    ];
                @endphp

                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="bg-gray-50 rounded-lg p-8">
                            <div class="flex text-yellow-400 mb-4">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < floor($testimonial['rating']))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-700 mb-6 italic">{{ $testimonial['text'] }}</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial['name']) }}&background=667eea&color=fff"
                                     alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $testimonial['name'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $testimonial['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination mt-6"></div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-16 bg-gradient-to-r from-purple-600 to-blue-600">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            {{ __('Get notified about new courses') }}
        </h2>
        <p class="text-purple-100 mb-8">
            {{ __('Subscribe to receive the latest courses and exclusive weekly offers') }}
        </p>

        <form class="flex flex-col sm:flex-row gap-3">
            <input
                type="email"
                placeholder="{{ __('Enter your email...') }}"
                class="flex-1 px-4 py-3 rounded-lg focus:outline-none"
                required
            >
            <button type="submit" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                {{ __('Subscribe') }}
            </button>
        </form>
    </div>
</section>

@endsection
