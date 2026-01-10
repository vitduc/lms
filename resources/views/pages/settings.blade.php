@extends('layouts.app')

@section('content')
@php
    $preferences = [
        ['label' => 'Email thông báo khóa học mới', 'description' => 'Nhận thông tin về các khóa học phù hợp với bạn', 'enabled' => true],
        ['label' => 'Thông báo nhắc học', 'description' => 'Nhận nhắc nhở khi bỏ lỡ lịch học', 'enabled' => true],
        ['label' => 'Thông báo khuyến mãi', 'description' => 'Thông tin ưu đãi, giảm giá từ LearnHub', 'enabled' => false],
        ['label' => 'Tin nhắn trong ứng dụng', 'description' => 'Nhận tin nhắn từ giảng viên và học viên khác', 'enabled' => true],
    ];
@endphp

<section class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div>
            <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Settings</p>
            <h1 class="text-4xl font-bold text-gray-900">Cài đặt tài khoản</h1>
            <p class="text-gray-500 mt-2">Quản lý thông tin cá nhân, tùy chọn thông báo và bảo mật.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 space-y-6">
            <div class="flex items-center justify-between border-b pb-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Thông tin cơ bản</p>
                    <h2 class="text-2xl font-bold text-gray-900">Hồ sơ</h2>
                </div>
                <button class="btn-primary text-white px-5 py-2 rounded-xl font-semibold">
                    Cập nhật
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Họ và tên</p>
                    <input type="text" value="{{ auth()->user()->name ?? 'Người dùng' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Email đăng nhập</p>
                    <input type="email" value="{{ auth()->user()->email ?? 'user@example.com' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Số điện thoại</p>
                    <input type="text" placeholder="+84 ..." class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Ngôn ngữ ưu tiên</p>
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                        <option>Tiếng Việt</option>
                        <option>English</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 space-y-6">
            <div class="flex items-center justify-between border-b pb-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Thông báo</p>
                    <h2 class="text-2xl font-bold text-gray-900">Tùy chọn gửi thông tin</h2>
                </div>
                <button class="text-sm text-gray-500 hover:text-gray-700">Thiết lập mặc định</button>
            </div>
            <div class="space-y-4">
                @foreach ($preferences as $pref)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl flex-wrap gap-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $pref['label'] }}</p>
                            <p class="text-sm text-gray-500">{{ $pref['description'] }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" {{ $pref['enabled'] ? 'checked' : '' }}>
                            <div class="w-12 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-purple-200 rounded-full peer peer-checked:bg-purple-600 transition-all relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:h-5 after:w-5 after:rounded-full after:transition-all peer-checked:after:translate-x-6"></div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 space-y-6">
            <div class="flex items-center justify-between border-b pb-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Bảo mật</p>
                    <h2 class="text-2xl font-bold text-gray-900">Thông tin đăng nhập</h2>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border border-gray-100 rounded-2xl">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                            <i class="fas fa-lock"></i>
                        </span>
                        <div>
                            <p class="text-sm text-gray-500">Mật khẩu</p>
                            <p class="font-semibold text-gray-900">Cập nhật 2 tuần trước</p>
                        </div>
                    </div>
                    <button class="text-sm text-purple-600 font-semibold hover:underline">Đổi mật khẩu</button>
                </div>
                <div class="p-4 border border-gray-100 rounded-2xl">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                            <i class="fas fa-mobile-alt"></i>
                        </span>
                        <div>
                            <p class="text-sm text-gray-500">Xác thực hai lớp</p>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->two_factor_enabled ? 'Đang bật' : 'Đang tắt' }}</p>
                        </div>
                    </div>
                    <a href="{{ localized_route('profile') }}#security" class="text-sm text-purple-600 font-semibold hover:underline">
                        Quản lý 2FA
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

