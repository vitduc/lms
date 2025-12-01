<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user()->loadMissing(['profile', 'roles']);

        $stats = [
            'completed_courses' => 12,
            'hours_learned' => 86,
            'achievements' => 4,
        ];

        return view('pages.profile', [
            'user' => $user,
            'profile' => $user->profile,
            'stats' => $stats,
        ]);
    }

    /**
     * Toggle two-factor authentication preference.
     */
    public function toggleTwoFactor(Request $request)
    {
        $validated = $request->validate([
            'two_factor_enabled' => 'required|boolean',
        ]);

        $user = $request->user();
        $user->two_factor_enabled = (bool) $validated['two_factor_enabled'];
        $user->save();

        $message = $user->two_factor_enabled
            ? 'Đã bật bảo mật 2 lớp (2FA) cho tài khoản của bạn.'
            : 'Đã tắt bảo mật 2 lớp (2FA). Bạn có thể bật lại bất cứ lúc nào.';

        return back()->with('success', $message);
    }
}

