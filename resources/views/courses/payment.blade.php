@extends('layouts.app')

@section('content')
<section class="pt-20 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ localized_route('courses.show', $course->slug) }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại khóa học
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Thông tin thanh toán</h2>

                    <form action="{{ localized_route('courses.payment.process', $course->id) }}" method="POST" id="payment-form">
                        @csrf

                        <!-- Course Summary -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $course->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $course->category->name }} • {{ $course->level->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-purple-600">₫{{ number_format($course->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Phương thức thanh toán</label>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition">
                                    <input type="radio" name="payment_method" value="credit_card" class="mr-3 text-purple-600" checked required>
                                    <i class="fas fa-credit-card text-2xl text-gray-400 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Thẻ tín dụng/Ghi nợ</p>
                                        <p class="text-sm text-gray-500">Visa, Mastercard, JCB</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition">
                                    <input type="radio" name="payment_method" value="paypal" class="mr-3 text-purple-600" required>
                                    <i class="fab fa-paypal text-2xl text-blue-500 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">PayPal</p>
                                        <p class="text-sm text-gray-500">Thanh toán qua PayPal</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="mr-3 text-purple-600" required>
                                    <i class="fas fa-university text-2xl text-green-500 mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Chuyển khoản ngân hàng</p>
                                        <p class="text-sm text-gray-500">Chuyển khoản trực tiếp</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Note: This is a demo payment form -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-yellow-600 mt-1"></i>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-semibold mb-1">Lưu ý:</p>
                                    <p>Đây là form thanh toán demo. Trong môi trường thực tế, bạn cần tích hợp với cổng thanh toán như Stripe, PayPal hoặc VNPay.</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary text-white w-full py-3 rounded-lg font-semibold text-lg">
                            <i class="fas fa-lock mr-2"></i>Thanh toán ₫{{ number_format($course->price, 0, ',', '.') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Giá khóa học</span>
                            <span class="font-semibold">₫{{ number_format($course->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Giảm giá</span>
                            <span class="font-semibold">₫0</span>
                        </div>
                        <hr>
                        <div class="flex justify-between">
                            <span class="font-bold text-gray-900">Tổng cộng</span>
                            <span class="text-2xl font-bold text-purple-600">₫{{ number_format($course->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-600">
                        <p><i class="fas fa-shield-alt mr-2"></i>Thanh toán an toàn và bảo mật</p>
                        <p class="mt-2"><i class="fas fa-undo mr-2"></i>Hoàn tiền trong 30 ngày nếu không hài lòng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

