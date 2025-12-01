@extends('layouts.app')

@section('content')
<section class="pt-24 pb-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl text-white p-10 shadow-xl relative overflow-hidden">
            <div class="max-w-2xl">
                <p class="text-sm uppercase tracking-[0.3em] text-purple-200">LearnHub for Instructors</p>
                <h1 class="text-4xl md:text-5xl font-extrabold mt-3 mb-4">Chia sẻ kiến thức, tạo dựng thương hiệu cá nhân</h1>
                <p class="text-lg text-purple-100 mb-6">
                    Tham gia cộng đồng giảng viên chất lượng cao, tiếp cận hàng chục nghìn học viên và tạo thu nhập bền vững.
                </p>
                <div class="flex flex-wrap gap-3">
                    <button class="bg-white text-purple-700 font-semibold px-8 py-3 rounded-full">
                        Bắt đầu dạy ngay
                    </button>
                    <button class="border border-white/60 px-8 py-3 rounded-full font-semibold text-white hover:bg-white/10">
                        Tải hướng dẫn giảng viên
                    </button>
                </div>
            </div>
            <div class="absolute -right-20 -bottom-20 w-72 h-72 rounded-full bg-white/10 blur-3xl"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ([
                ['icon' => 'fa-lightbulb', 'title' => 'Tự do xây dựng nội dung', 'desc' => 'Dễ dàng tạo khóa học với video, bài tập, quiz, bài tập dự án.'],
                ['icon' => 'fa-globe', 'title' => 'Tiếp cận học viên toàn cầu', 'desc' => 'LearnHub quảng bá khóa học đến hàng chục nghìn người học.'],
                ['icon' => 'fa-wallet', 'title' => 'Thu nhập minh bạch', 'desc' => 'Theo dõi doanh thu theo thời gian thực và nhận thanh toán định kỳ.'],
            ] as $feature)
                <div class="bg-white rounded-2xl p-6 shadow-md flex flex-col gap-3">
                    <span class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fas {{ $feature['icon'] }}"></i>
                    </span>
                    <h3 class="text-xl font-bold text-gray-900">{{ $feature['title'] }}</h3>
                    <p class="text-gray-500">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl shadow-md p-8 space-y-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Quy trình</p>
                    <h2 class="text-3xl font-bold text-gray-900">4 bước trở thành giảng viên LearnHub</h2>
                </div>
                <button class="px-6 py-3 border border-gray-300 rounded-full text-gray-700 font-semibold hover:bg-gray-50">
                    Nhận tư vấn 1-1
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach ([
                    ['step' => 1, 'title' => 'Đăng ký', 'desc' => 'Tạo tài khoản giảng viên và hoàn thiện hồ sơ chuyên môn.'],
                    ['step' => 2, 'title' => 'Thiết kế khóa học', 'desc' => 'Sử dụng bộ công cụ hỗ trợ để xây dựng nội dung hấp dẫn.'],
                    ['step' => 3, 'title' => 'Xuất bản & quảng bá', 'desc' => 'LearnHub hỗ trợ kiểm duyệt và chạy chiến dịch marketing.'],
                    ['step' => 4, 'title' => 'Theo dõi & phát triển', 'desc' => 'Theo dõi học viên, phản hồi và doanh thu theo thời gian thực.'],
                ] as $stage)
                    <div class="border border-gray-100 rounded-2xl p-5 flex flex-col gap-3">
                        <span class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                            {{ $stage['step'] }}
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $stage['title'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $stage['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-3xl p-8 flex flex-col lg:flex-row gap-8 items-center">
            <div class="flex-1 space-y-4">
                <p class="text-sm uppercase tracking-wide text-purple-500 font-semibold">Câu chuyện thành công</p>
                <h2 class="text-3xl font-bold text-gray-900">“Tôi đạt 5.000 học viên chỉ sau 6 tháng”</h2>
                <p class="text-gray-600">
                    “LearnHub giúp tôi xây dựng thương hiệu cá nhân và mở rộng mạng lưới học viên quốc tế. Đội ngũ hỗ trợ giảng viên rất tận tâm.”
                </p>
                <p class="font-semibold text-gray-900">— Lê Minh Trang, Giảng viên Product Design</p>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 w-full max-w-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Đăng ký trở thành giảng viên</h3>
                <form class="space-y-3">
                    <input type="text" placeholder="Họ và tên" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    <input type="email" placeholder="Email" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    <input type="text" placeholder="Chuyên môn giảng dạy" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    <button type="submit" class="btn-primary w-full text-white py-3 rounded-xl font-semibold">
                        Gửi đăng ký
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

