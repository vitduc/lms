<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\TwoFactorToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    /**
     * Show OTP Entry Form
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request)
    {
        if (!session('2fa:user_id')) {
            return redirect(localized_route('login'));
        }

        return view('auth.verify-2fa');
    }

    /**
     * Verify OTP
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $userId = session('2fa:user_id');
        if (!$userId) {
            return redirect(localized_route('login'))->withErrors(['otp' => 'Yêu cầu xác thực không hợp lệ.']);
        }

        $token = TwoFactorToken::where('user_id', $userId)
            ->where('used', false)
            ->where('expires_at', '>=', Carbon::now())
            ->latest()
            ->first();

        if (!$token) {
            return back()->withErrors(['otp' => 'Mã không hợp lệ hoặc đã hết hạn. Vui lòng yêu cầu gửi lại.']);
        }

        if (!Hash::check($request->input('otp'), $token->token_hash)) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ.']);
        }

        // mark token used
        $token->used = true;
        $token->save();

        // Log the user in
        $user = User::find($userId);
        if (!$user) {
            return redirect(localized_route('login'))->withErrors(['otp' => 'Người dùng không tồn tại.']);
        }

        $remember = session('2fa:remember', false);
        Auth::login($user, $remember);

        // Remove pending session keys
        $request->session()->forget('2fa:user_id');
        $request->session()->forget('2fa:remember');

        return redirect()->intended(localized_route('home'))->with('success', 'Xác thực thành công!');
    }

    /**
     * Resend OTP
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        $userId = session('2fa:user_id');
        if (!$userId) {
            return redirect(localized_route('login'));
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect(localized_route('login'));
        }

        // Create new OTP
        $otp = random_int(100000, 999999);
        $tokenHash = Hash::make((string) $otp);

        $token = TwoFactorToken::create([
            'user_id' => $user->id,
            'token_hash' => $tokenHash,
            'expires_at' => Carbon::now()->addMinutes(5),
            'used' => false,
        ]);

        // send mail (synchronous)
        Mail::to($user->email)->send(new SendOtpMail($user, $otp));

        return back()->with('success', 'Mã OTP đã được gửi lại đến email của bạn.');
    }
}
