@extends('layouts.app')

@section('content')
<section class="pt-20 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Courses') }}</h1>
            <p class="text-gray-600">{{ __('Explore thousands of high-quality courses') }}</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Course name...') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Category') }}</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">{{ __('All') }}</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->translated_name ?? $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Level') }}</label>
                    <select name="level" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">{{ __('All') }}</option>
                        @foreach(\App\Models\Level::all() as $level)
                            <option value="{{ $level->slug }}" {{ request('level') === $level->slug ? 'selected' : '' }}>{{ $level->translated_name ?? $level->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Price') }}</label>
                    <select name="price" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">{{ __('All') }}</option>
                        <option value="free" {{ request('price') === 'free' ? 'selected' : '' }}>{{ __('Free') }}</option>
                        <option value="paid" {{ request('price') === 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-semibold">
                        <i class="fas fa-search mr-2"></i>{{ __('Search') }}
                    </button>
{{--                    <a href="{{ route('courses.index') }}" class="border border-gray-300 px-6 py-2 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">--}}
{{--                        <i class="fas fa-redo mr-2"></i>Reset--}}
{{--                    </a>--}}
                </div>
            </form>
        </div>

        <!-- Courses Grid -->
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($courses as $course)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="relative h-48">
                            <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @if($course->isFree())
                                <span class="absolute top-4 right-4 bg-emerald-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ __('Free') }}
                                </span>
                            @else
                                <span class="absolute top-4 right-4 bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    ₫{{ number_format($course->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-2">
                                @if($course->categories->isNotEmpty())
                                <span class="text-xs px-2 py-1 bg-purple-100 text-purple-600 rounded-full">{{ $course->categories->map(fn($cat) => $cat->translated_name ?? $cat->name)->join(', ') }}</span>
                                @endif
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded-full">{{ $course->level->translated_name ?? $course->level->name }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->translated_title ?? $course->title }}</h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $course->translated_description ?? $course->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $course->instructor->name }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $course->enrollments->count() }} {{ __('students') }}</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ localized_route('courses.show', $course->slug) }}" class="btn-primary text-white w-full text-center py-2 rounded-lg font-semibold block">
                                    {{ __('View details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('No courses found') }}</h3>
                <p class="text-gray-500">{{ __('Try changing filters to find suitable courses') }}</p>
            </div>
        @endif
    </div>
</section>
@endsection

