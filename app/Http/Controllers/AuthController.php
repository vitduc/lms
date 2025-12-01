<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TwoFactorToken;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Show Login Form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Store Login (with 2FA via email)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
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

        // Generate OTP and send to user's email
        $otp = random_int(100000, 999999);
        $tokenHash = Hash::make((string) $otp);

        TwoFactorToken::create([
            'user_id' => $user->id,
            'token_hash' => $tokenHash,
            'expires_at' => Carbon::now()->addMinutes(5),
            'used' => false,
        ]);

        // send mail (synchronous)
        Mail::to($user->email)->send(new SendOtpMail($user, $otp));

        // store pending user id in session
        $request->session()->put('2fa:user_id', $user->id);
        $request->session()->put('2fa:remember', $request->boolean('remember'));

        return redirect()->route('2fa.show')->with('success', 'Mã xác thực đã được gửi tới email của bạn.');
    }

    /**
     * Show Register Form
     *
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Store Register
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // lowercase
                'regex:/[A-Z]/',      // uppercase
                'regex:/[0-9]/',      // digit
                'regex:/[@$!%*?&]/',  // special character
            ],
            'terms' => 'accepted',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.max' => 'Họ và tên không quá 255 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email này đã được đăng ký',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu không khớp',
            'password.regex' => 'Mật khẩu phải chứa chữ hoa, chữ thường, số và ký tự đặc biệt',
            'terms.accepted' => 'Vui lòng đồng ý với điều khoản dịch vụ',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (method_exists($user, 'roles')) {
            $user->roles()->attach(1); // Assuming 1 is Student role ID
        }

        $otp = random_int(100000, 999999);
        $tokenHash = Hash::make((string) $otp);

        TwoFactorToken::create([
            'user_id' => $user->id,
            'token_hash' => $tokenHash,
            'expires_at' => Carbon::now()->addMinutes(5),
            'used' => false,
        ]);

        Mail::to($user->email)->send(new SendOtpMail($user, $otp));

        // store pending user id in session
        $request->session()->put('2fa:user_id', $user->id);

        return redirect('/2fa')->with('success', 'Tài khoản đã được tạo. Vui lòng nhập mã OTP đã gửi tới email để hoàn tất đăng nhập.');
    }

    /**
     * Logout
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đã đăng xuất thành công!');
    }
}
