@extends('layouts.app')

@section('content')
<section class="pt-20 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Thông báo</h1>
                    <p class="text-gray-500 mt-1">Tất cả thông báo của bạn</p>
                </div>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary text-white px-4 py-2 rounded-lg font-semibold text-sm">
                            <i class="fas fa-check-double mr-2"></i>Đánh dấu tất cả đã đọc
                        </button>
                    </form>
                @endif
            </div>

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($notifications->count() > 0)
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition {{ $notification->read_at ? '' : 'bg-blue-50 border-blue-200' }}">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                    @if($notification->read_at) bg-gray-100 text-gray-600 @else bg-purple-100 text-purple-600 @endif">
                                    @if(str_contains($notification->type, 'Course'))
                                        <i class="fas fa-book"></i>
                                    @elseif(str_contains($notification->type, 'Lesson'))
                                        <i class="fas fa-video"></i>
                                    @elseif(str_contains($notification->type, 'Enrollment'))
                                        <i class="fas fa-user-plus"></i>
                                    @else
                                        <i class="fas fa-bell"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 mb-1">
                                                {{ $notification->data['title'] ?? 'Thông báo mới' }}
                                            </h3>
                                            <p class="text-gray-600 text-sm mb-2">
                                                {{ $notification->data['message'] ?? '' }}
                                            </p>
                                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                                <span><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}</span>
                                                @if(!$notification->read_at)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full font-semibold">Mới</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="flex-shrink-0">
                                                @csrf
                                                <button type="submit" class="text-purple-600 hover:text-purple-700 text-sm">
                                                    <i class="fas fa-check"></i> Đánh dấu đã đọc
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @if(isset($notification->data['action_url']))
                                        <div class="mt-3">
                                            <a href="{{ $notification->data['action_url'] }}" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                                                Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-purple-100 to-blue-100 flex items-center justify-center">
                        <i class="fas fa-bell-slash text-4xl text-purple-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Chưa có thông báo</h3>
                    <p class="text-gray-500 mb-6">Các thông báo mới về khóa học, bài học và hoạt động sẽ xuất hiện ở đây</p>
                    <a href="{{ route('home') }}" class="btn-primary text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Về trang chủ
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

