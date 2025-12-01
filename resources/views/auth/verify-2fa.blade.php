@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <i class="fas fa-shield-alt text-4xl gradient-text mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Xác thực 2 bước</h1>
            <p class="text-gray-600">Nhập mã 6 chữ số đã được gửi tới email của bạn.</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            @if (session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Mã OTP</label>
                    <input type="text" id="otp" name="otp" maxlength="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" required>
                    @error('otp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-primary text-white font-semibold py-2 rounded-lg">Xác nhận</button>
            </form>

            <div class="mt-4 text-center text-sm">
                <form method="POST" action="{{ route('2fa.resend') }}">
                    @csrf
                    <button type="submit" class="text-purple-600 hover:underline">Gửi lại mã OTP</button>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center text-xs text-gray-600">
            <p>Nếu bạn không nhận được email, kiểm tra thư mục Spam hoặc thử gửi lại.</p>
        </div>
    </div>
</section>
@endsection
