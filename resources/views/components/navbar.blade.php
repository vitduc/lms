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
