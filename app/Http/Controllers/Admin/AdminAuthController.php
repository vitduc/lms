<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Show Admin Login Form
     */
    public function showLogin()
    {
        // If already logged in as admin, redirect to dashboard
        if (Auth::check() && Auth::user()->roles->contains('name', 'admin')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle Admin Login
     */
    public function storeLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
        ]);

        $user = User::where('email', $validated['email'])->first();
        
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])->onlyInput('email');
        }

        // Check if user has admin role
        $isAdmin = $user->roles->contains('name', 'admin');
        
        if (!$isAdmin) {
            return back()->withErrors([
                'email' => 'Bạn không có quyền truy cập vào khu vực quản trị.',
            ])->onlyInput('email');
        }

        // Log in the admin (skip 2FA for admin login)
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập quản trị thành công!');
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất thành công!');
    }
}

