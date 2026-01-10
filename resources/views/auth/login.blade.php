@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <i class="fas fa-graduation-cap text-4xl gradient-text mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">LearnHub</h1>
            <p class="text-gray-600">Đăng nhập vào tài khoản của bạn</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ localized_route('login.store') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-purple-600"></i>Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        placeholder="your@email.com"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-purple-600"></i>Mật khẩu
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded cursor-pointer"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                        Ghi nhớ tôi
                    </label>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full btn-primary text-white font-semibold py-2 rounded-lg transition"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập
                </button>

                <!-- Forgot Password Link -->
                <div class="text-center">
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                        Quên mật khẩu?
                    </a>
                </div>
            </form>

            <!-- Sign Up Link -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-center text-gray-600 text-sm">
                    Chưa có tài khoản?
                    <a href="{{ localized_route('register') }}" class="font-semibold text-purple-600 hover:text-purple-700">
                        Đăng ký ngay
                    </a>
                </p>
            </div>

            <!-- Social Login -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Hoặc tiếp tục với</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition">
                        <i class="fab fa-google text-lg"></i>
                    </button>
                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition">
                        <i class="fab fa-github text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Message -->
        <div class="mt-6 text-center text-xs text-gray-600">
            <p><i class="fas fa-shield-alt mr-1 text-green-600"></i>Dữ liệu của bạn được bảo mật 100%</p>
        </div>
    </div>
</section>
@endsection
