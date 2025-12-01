@extends('layouts.app')

@section('content')
@php
    $socialLinks = $profile && $profile->social_links
        ? json_decode($profile->social_links, true)
        : [];
    $canTeach = $user->roles->contains('name', 'instructor') || $user->roles->contains('name', 'admin');
    $teachLink = route('teach');
    $teachLabel = $canTeach ? 'Quản lý khóa giảng' : 'Đăng ký giảng dạy';
@endphp
<section class="pt-20 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex items-center gap-4">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff"
                            alt="{{ $user->name }}"
                            class="w-16 h-16 rounded-full border-4 border-purple-100"
                        >
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                        <div class="p-3 rounded-lg bg-purple-50">
                            <p class="text-xl font-bold text-purple-600">{{ $stats['completed_courses'] }}</p>
                            <p class="text-xs text-gray-500">Khóa học</p>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <p class="text-xl font-bold text-blue-600">{{ $stats['hours_learned'] }}</p>
                            <p class="text-xs text-gray-500">Giờ học</p>
                        </div>
                        <div class="p-3 rounded-lg bg-emerald-50">
                            <p class="text-xl font-bold text-emerald-600">{{ $stats['achievements'] }}</p>
                            <p class="text-xs text-gray-500">Huy hiệu</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-2xl divide-y">
                    <a href="#profile-information" class="block px-6 py-4 text-gray-700 hover:text-purple-600 hover:bg-purple-50 transition">
                        <i class="fas fa-user-circle mr-3 text-purple-500"></i> Thông tin cá nhân
                    </a>
                    <a href="#contact" class="block px-6 py-4 text-gray-700 hover:text-purple-600 hover:bg-purple-50 transition">
                        <i class="fas fa-address-book mr-3 text-purple-500"></i> Liên hệ
                    </a>
                    <a href="#security" class="block px-6 py-4 text-gray-700 hover:text-purple-600 hover:bg-purple-50 transition">
                        <i class="fas fa-shield-alt mr-3 text-purple-500"></i> Bảo mật
                    </a>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-8">
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- My Page quick actions -->
                <div class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">My Page</p>
                            <h2 class="text-2xl font-bold text-gray-900">Bảng điều khiển cá nhân</h2>
                            <p class="text-gray-500 text-sm mt-1">Truy cập nhanh các khu vực dành riêng cho bạn.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        <a href="{{ route('profile') }}" class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 hover:border-purple-200 hover:bg-purple-50 transition">
                            <span class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                                <i class="fas fa-user"></i>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Hồ sơ</p>
                                <p class="font-semibold text-gray-900">Thông tin cá nhân</p>
                            </div>
                        </a>
                        <a href="{{ route('my-courses') }}" class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 hover:border-indigo-200 hover:bg-indigo-50 transition">
                            <span class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">
                                <i class="fas fa-book"></i>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Học tập</p>
                                <p class="font-semibold text-gray-900">Khóa học của tôi</p>
                            </div>
                        </a>
                        <a href="{{ route('dashboard') }}" class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 hover:border-emerald-200 hover:bg-emerald-50 transition">
                            <span class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Theo dõi</p>
                                <p class="font-semibold text-gray-900">Dashboard</p>
                            </div>
                        </a>
                        <a href="{{ $teachLink }}" class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 hover:border-amber-200 hover:bg-amber-50 transition">
                            <span class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">{{ $canTeach ? 'Giảng viên' : 'Cơ hội' }}</p>
                                <p class="font-semibold text-gray-900">{{ $teachLabel }}</p>
                            </div>
                        </a>
                        <a href="{{ route('settings') }}" class="border border-gray-100 rounded-2xl p-4 flex items-center gap-4 hover:border-gray-300 hover:bg-gray-50 transition">
                            <span class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-xl">
                                <i class="fas fa-cog"></i>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Tùy chỉnh</p>
                                <p class="font-semibold text-gray-900">Cài đặt</p>
                            </div>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="border border-gray-100 rounded-2xl p-0 hover:border-red-200 hover:bg-red-50 transition">
                            @csrf
                            <button type="submit" class="w-full p-4 flex items-center gap-4 text-left">
                                <span class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                <div>
                                    <p class="text-sm text-gray-500">Thoát</p>
                                    <p class="font-semibold text-gray-900">Đăng xuất</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>

                <div id="profile-information" class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Hồ sơ</p>
                            <h2 class="text-2xl font-bold text-gray-900">Thông tin cá nhân</h2>
                            <p class="text-gray-500 text-sm mt-1">Cập nhật để học viên khác hiểu thêm về bạn</p>
                        </div>
                        <button class="btn-primary text-white px-5 py-2 rounded-lg font-semibold" type="button">
                            <i class="fas fa-pen mr-2"></i> Chỉnh sửa
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Họ và tên</p>
                            <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Email</p>
                            <p class="text-gray-900 font-semibold">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Quốc gia</p>
                            <p class="text-gray-900 font-semibold">{{ optional($profile)->country ?? 'Chưa cập nhật' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Thành phố</p>
                            <p class="text-gray-900 font-semibold">{{ optional($profile)->city ?? 'Chưa cập nhật' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 mb-1">Tiểu sử</p>
                            <p class="text-gray-700 leading-relaxed">
                                {{ optional($profile)->bio ?? 'Hãy chia sẻ một chút về bản thân để giảng viên và học viên khác hiểu thêm về bạn.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div id="contact" class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Liên hệ</p>
                            <h2 class="text-2xl font-bold text-gray-900">Thông tin liên lạc</h2>
                        </div>
                        <button class="border border-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold hover:bg-gray-50" type="button">
                            Cập nhật
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow">
                                <i class="fas fa-phone text-purple-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Số điện thoại</p>
                                <p class="text-gray-900 font-semibold">{{ optional($profile)->phone ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow">
                                <i class="fas fa-globe-asia text-purple-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Website / Mạng xã hội</p>
                                <p class="text-gray-900 font-semibold">
                                    {{ $socialLinks['website'] ?? 'Chưa cập nhật' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="security" class="bg-white shadow-md rounded-2xl p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Bảo mật</p>
                            <h2 class="text-2xl font-bold text-gray-900">Cài đặt tài khoản</h2>
                        </div>
                        <span class="text-sm text-gray-500">Cập nhật lần cuối {{ now()->format('d/m/Y') }}</span>
                    </div>

                    <div class="p-5 border border-gray-100 rounded-2xl flex flex-col gap-4">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Xác thực hai lớp (2FA)</h3>
                                <p class="text-sm text-gray-500">
                                    Tăng cường bảo mật bằng cách yêu cầu mã OTP cho mỗi lần đăng nhập.
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-semibold {{ $user->two_factor_enabled ? 'text-emerald-600' : 'text-gray-500' }}">
                                    {{ $user->two_factor_enabled ? 'Đang bật' : 'Đang tắt' }}
                                </span>
                                <form action="{{ route('profile.two-factor') }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="two_factor_enabled" value="0">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="two_factor_enabled"
                                            value="1"
                                            class="sr-only peer"
                                            id="two-factor-toggle"
                                            {{ $user->two_factor_enabled ? 'checked' : '' }}
                                        >
                                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-200 rounded-full peer peer-checked:bg-purple-600 transition-colors relative after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:border-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-7"></div>
                                    </label>
                                </form>
                            </div>
                        </div>
                        @error('two_factor_enabled')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border border-gray-100 rounded-2xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                                <div>
                                    <p class="text-sm text-gray-500">Mật khẩu</p>
                                    <p class="font-semibold text-gray-900">Đã cập nhật</p>
                                </div>
                            </div>
                            <button class="text-sm text-purple-600 font-medium hover:underline" type="button">
                                Thay đổi mật khẩu
                            </button>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <div>
                                    <p class="text-sm text-gray-500">Thông báo</p>
                                    <p class="font-semibold text-gray-900">Email & In-app</p>
                                </div>
                            </div>
                            <button class="text-sm text-purple-600 font-medium hover:underline" type="button">
                                Quản lý thông báo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('two-factor-toggle')?.addEventListener('change', function () {
        this.closest('form')?.submit();
    });
</script>
@endpush

