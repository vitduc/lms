@extends('layouts.app')

@section('content')
@php
    $stats = [
        ['label' => 'Giờ học trong tuần', 'value' => '12h', 'trend' => '+2h', 'icon' => 'fa-clock'],
        ['label' => 'Khóa đang học', 'value' => '5', 'trend' => '+1', 'icon' => 'fa-book'],
        ['label' => 'Bài tập đã hoàn thành', 'value' => '18', 'trend' => '+6', 'icon' => 'fa-check-circle'],
        ['label' => 'Chuỗi ngày học', 'value' => '7 ngày', 'trend' => '+2', 'icon' => 'fa-fire'],
    ];

    $roadmap = [
        ['title' => 'Hoàn thành khóa Laravel', 'percent' => 70, 'deadline' => '15/12', 'color' => 'purple'],
        ['title' => 'Luyện đề UX Challenge', 'percent' => 40, 'deadline' => '20/12', 'color' => 'blue'],
        ['title' => 'Chiến dịch Marketing', 'percent' => 25, 'deadline' => '30/12', 'color' => 'emerald'],
    ];
@endphp

<section class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div>
            <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Dashboard</p>
            <h1 class="text-4xl font-bold text-gray-900">Xin chào, {{ auth()->user()->name ?? 'LearnHubber' }} 👋</h1>
            <p class="text-gray-500 mt-2">Theo dõi tiến độ học tập, mục tiêu và hoạt động gần đây.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach ($stats as $stat)
                <div class="bg-white rounded-2xl shadow-md p-6 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                        <i class="fas {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                        <p class="text-xs font-semibold text-emerald-600 mt-1">{{ $stat['trend'] }} so với tuần trước</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Lộ trình</p>
                        <h2 class="text-2xl font-bold text-gray-900">Mục tiêu đang theo đuổi</h2>
                    </div>
                    <button class="text-sm text-purple-600 font-semibold hover:text-purple-700">Thêm mục tiêu</button>
                </div>

                <div class="space-y-5">
                    @foreach ($roadmap as $item)
                        <div class="p-4 border border-gray-100 rounded-2xl">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item['title'] }}</p>
                                    <p class="text-sm text-gray-500">Thời hạn {{ $item['deadline'] }}</p>
                                </div>
                                <span class="text-sm font-semibold text-gray-600">{{ $item['percent'] }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 rounded-full">
                                <div class="h-full rounded-full
                                    @if ($item['color'] === 'purple') bg-gradient-to-r from-purple-500 to-pink-500
                                    @elseif ($item['color'] === 'blue') bg-gradient-to-r from-blue-500 to-cyan-400
                                    @else bg-gradient-to-r from-emerald-500 to-lime-400 @endif"
                                    style="width: {{ $item['percent'] }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Hoạt động gần đây</h2>
                    <button class="text-sm text-gray-500 hover:text-gray-700">Xem tất cả</button>
                </div>
                <div class="space-y-4">
                    @foreach (['Hoàn thành chương 6 - Laravel', 'Nhận huy hiệu UI/UX', 'Đạt 90% bài quiz Marketing'] as $activity)
                        <div class="flex items-start gap-3">
                            <span class="w-10 h-10 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $activity }}</p>
                                <p class="text-sm text-gray-500">3 giờ trước</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-md p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Lịch học</h2>
                    <button class="text-sm text-purple-600 font-semibold">Thêm lịch</button>
                </div>
                <div class="space-y-3">
                    @foreach (['Thứ 2, 20:00' => 'Workshop UI', 'Thứ 4, 19:30' => 'Live Class Laravel', 'Thứ 6, 21:00' => 'Quiz Marketing'] as $time => $event)
                        <div class="p-4 border border-gray-100 rounded-2xl flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">{{ $time }}</p>
                                <p class="font-semibold text-gray-900">{{ $event }}</p>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-50 text-purple-600">Online</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Huy hiệu & thành tựu</h2>
                    <button class="text-sm text-gray-500 hover:text-gray-700">Chi tiết</button>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center">
                    @foreach (['Learner Pro', 'Quiz Master', 'UI Wizard'] as $badge)
                        <div class="p-4 border border-gray-100 rounded-2xl">
                            <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-500 flex items-center justify-center mx-auto mb-2 text-2xl">
                                <i class="fas fa-medal"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-900">{{ $badge }}</p>
                            <p class="text-xs text-gray-500">Unlocked</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

