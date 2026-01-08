@extends('layouts.app')

@section('content')
<section class="pt-20 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="h-64 md:h-96">
                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold">{{ $course->category->name }}</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">{{ $course->level->name }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                            @if($reviewsCount > 0)
                                <div class="flex items-center gap-3 bg-yellow-50 border border-yellow-200 rounded-full px-4 py-2">
                                    <div class="flex items-center text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($averageRating))
                                                <i class="fas fa-star text-sm"></i>
                                            @else
                                                <i class="far fa-star text-sm"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="text-sm text-gray-700">
                                        <span class="font-semibold">{{ number_format($averageRating, 1) }}/5.0</span>
                                        <span class="text-gray-500">• {{ $reviewsCount }} đánh giá</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-gray-500 italic">Chưa có đánh giá nào</div>
                            @endif
                        </div>
                        <div class="prose max-w-none">
                            {!! $course->content ?? $course->description !!}
                        </div>
                        <div class="border-t pt-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Về giảng viên</h2>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($course->instructor->name) }}&background=667eea&color=fff" alt="{{ $course->instructor->name }}" class="w-16 h-16 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $course->instructor->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $course->instructor->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Đánh giá từ học viên</h2>
                            @if($reviewsCount > 0)
                                <div class="space-y-4">
                                    @foreach($course->reviews->take(5) as $review)
                                        <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center gap-3">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=667eea&color=fff" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full">
                                                    <div>
                                                        <p class="font-semibold text-gray-900 text-sm">{{ $review->user->name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-1 text-yellow-400">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="fas fa-star text-xs"></i>
                                                        @else
                                                            <i class="far fa-star text-xs"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            @if($review->title)
                                                <p class="font-semibold text-gray-900 mb-1 text-sm">{{ $review->title }}</p>
                                            @endif
                                            <p class="text-sm text-gray-700">{{ $review->content }}</p>
                                            @if($review->is_verified_purchase)
                                                <p class="mt-2 text-xs text-emerald-600 flex items-center gap-1">
                                                    <i class="fas fa-badge-check"></i> Đã mua khóa học này
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($reviewsCount > 5)
                                        <p class="text-sm text-gray-500">... và {{ $reviewsCount - 5 }} đánh giá khác</p>
                                    @endif
                                </div>
                            @else
                                <div class="bg-gray-50 border border-dashed border-gray-200 rounded-xl p-6 text-center text-gray-500 text-sm">
                                    Chưa có đánh giá nào cho khóa học này. Hãy là người đầu tiên chia sẻ cảm nhận sau khi hoàn thành khóa học.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <div class="text-center mb-6">
                        @if($course->isFree())
                            <div class="text-4xl font-bold text-emerald-600 mb-2">Miễn phí</div>
                        @else
                            <div class="text-4xl font-bold text-purple-600 mb-2">₫{{ number_format($course->price, 0, ',', '.') }}</div>
                        @endif
                        <p class="text-sm text-gray-500">{{ $course->enrollments->count() }} học viên đã đăng ký</p>
                    </div>

                    @if($isEnrolled)
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center gap-2 text-emerald-700">
                                <i class="fas fa-check-circle"></i>
                                <span class="font-semibold">Bạn đã đăng ký khóa học này</span>
                            </div>
                        </div>
                        <a href="{{ route('my-courses') }}" class="btn-primary text-white w-full text-center py-3 rounded-lg font-semibold block">
                            <i class="fas fa-book-open mr-2"></i>Vào học ngay
                        </a>
                    @else
                        @if($course->isFree())
                            <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary text-white w-full py-3 rounded-lg font-semibold">
                                    <i class="fas fa-user-plus mr-2"></i>Đăng ký miễn phí
                                </button>
                            </form>
                        @else
                            <a href="{{ route('courses.payment', $course->id) }}" class="btn-primary text-white w-full text-center py-3 rounded-lg font-semibold block">
                                <i class="fas fa-credit-card mr-2"></i>Thanh toán và đăng ký
                            </a>
                        @endif
                    @endif

                    <div class="mt-6 space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-clock text-purple-600"></i>
                            <span>Học mọi lúc mọi nơi</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-certificate text-purple-600"></i>
                            <span>Chứng chỉ hoàn thành</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-headset text-purple-600"></i>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

