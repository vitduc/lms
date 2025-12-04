<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-graduation-cap text-2xl gradient-text"></i>
                <span class="text-xl font-bold gradient-text">LearnHub</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-purple-600 transition">Home</a>
                <a href="/courses" class="text-gray-700 hover:text-purple-600 transition">Courses</a>
                <a href="/categories" class="text-gray-700 hover:text-purple-600 transition">Categories</a>
                <a href="/instructors" class="text-gray-700 hover:text-purple-600 transition">Instructors</a>
                <a href="/blog" class="text-gray-700 hover:text-purple-600 transition">Blog</a>
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-4">
                @if (auth()->check())
                    <!-- Notifications Dropdown -->
                    <div class="relative" id="notifications-container">
                        <button id="notifications-btn" class="relative p-2 text-gray-700 hover:text-purple-600 transition focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            @php
                                try {
                                    $unreadCount = auth()->user()->unreadNotifications->count();
                                } catch (\Exception $e) {
                                    $unreadCount = 0;
                                }
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse" id="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown Menu -->
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50 max-h-96 overflow-y-auto">
                            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900">
                                    <i class="fas fa-bell mr-2 text-purple-600"></i>Thông báo
                                    @if($unreadCount > 0)
                                        <span class="ml-2 text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full">{{ $unreadCount }} mới</span>
                                    @endif
                                </h3>
                                @if($unreadCount > 0)
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-purple-600 hover:text-purple-700 font-semibold">
                                            <i class="fas fa-check-double mr-1"></i>Đánh dấu tất cả
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div id="notifications-list" class="divide-y divide-gray-100">
                                @php
                                    try {
                                        $latestNotifications = auth()->user()->notifications()->take(5)->get();
                                    } catch (\Exception $e) {
                                        $latestNotifications = collect();
                                    }
                                @endphp
                                @if($latestNotifications->count() > 0)
                                    @foreach($latestNotifications as $notification)
                                        <div class="p-4 hover:bg-gray-50 transition {{ $notification->read_at ? '' : 'bg-blue-50 border-l-4 border-blue-500' }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                                    @if($notification->read_at) bg-gray-100 text-gray-600 @else bg-purple-100 text-purple-600 @endif">
                                                    @if(str_contains($notification->type, 'Course'))
                                                        <i class="fas fa-book text-xs"></i>
                                                    @elseif(str_contains($notification->type, 'Lesson'))
                                                        <i class="fas fa-video text-xs"></i>
                                                    @elseif(str_contains($notification->type, 'Enrollment'))
                                                        <i class="fas fa-user-plus text-xs"></i>
                                                    @else
                                                        <i class="fas fa-bell text-xs"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $notification->data['title'] ?? 'Thông báo mới' }}
                                                    </p>
                                                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                                        {{ $notification->data['message'] ?? '' }}
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        <i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2 animate-pulse"></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-8 text-center text-gray-500">
                                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-bell-slash text-2xl text-gray-400"></i>
                                        </div>
                                        <p class="text-sm font-medium text-gray-600 mb-1">Chưa có thông báo</p>
                                        <p class="text-xs text-gray-500">Các thông báo mới sẽ xuất hiện ở đây</p>
                                    </div>
                                @endif
                            </div>
                            @if($latestNotifications->count() > 0)
                                <div class="p-3 border-t border-gray-200 text-center bg-gray-50">
                                    <a href="{{ route('notifications.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-semibold inline-flex items-center">
                                        Xem tất cả thông báo <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="p-3 border-t border-gray-200 text-center bg-gray-50">
                                    <a href="{{ route('notifications.index') }}" class="text-sm text-gray-600 hover:text-gray-700 font-medium">
                                        Trang thông báo <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Authenticated -->
                    <div class="relative">
                        <button id="user-dropdown-btn" class="flex items-center space-x-2 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=667eea&color=fff"
                                 alt="Avatar" class="w-8 h-8 rounded-full">
                            <span class="hidden sm:inline text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-600"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="/my-courses" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-book mr-2"></i>My Courses
                            </a>
                            <a href="/dashboard" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-chart-line mr-2"></i>Dashboard
                            </a>
                            @if (auth()->user()->roles->contains('name', 'instructor') || auth()->user()->roles->contains('name', 'admin'))
                                <a href="/instructor/courses" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-chalkboard mr-2"></i>Teach
                                </a>
                            @else
                                <a href="/become-instructor" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-star mr-2"></i>Become Instructor
                                </a>
                            @endif
                            <hr class="my-2">
                            <form action="/logout" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- User Not Authenticated -->
                    <a href="/login" class="text-gray-700 hover:text-purple-600 transition font-medium">
                        Login
                    </a>
                    <a href="/register" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                        Register
                    </a>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <a href="/" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
            <a href="/courses" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Courses</a>
            <a href="/categories" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Categories</a>
            <a href="/instructors" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Instructors</a>
            <a href="/blog" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Blog</a>
        </div>
    </div>
</nav>
