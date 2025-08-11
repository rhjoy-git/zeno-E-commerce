<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\OtpService;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Middleware\CheckOtpDailyLimit;

class OTPVerificationController extends Controller
{
    public function showOtpForm($email)
    {
        $user = User::where('email', $email)
            ->select('id', 'email', 'otp', 'otp_expires_at', 'otp_blocked_until')
            ->firstOrFail();

        // Check if OTP was already verified
        if ($user->otp === null) {
            return redirect()->route('login')->with('error', 'OTP already verified.');
        }

        // Check if user is blocked from resending
        if ($user->otp_blocked_until && now()->lt($user->otp_blocked_until)) {
            $remaining = now()->diffInMinutes($user->otp_blocked_until);
            return redirect()->back()->with('error', "Too many attempts. Try again in {$remaining} minutes.");
        }
        // Convert to Carbon if it's a string
        if (is_string($user->otp_expires_at)) {
            $user->otp_expires_at = \Carbon\Carbon::parse($user->otp_expires_at);
        }
        return view('auth.verify-otp', [
            'user' => $user,
            'remainingSeconds' => now()->diffInSeconds($user->otp_expires_at)
        ]);
    }

    public function resendOtp(Request $request, $email)
    {
        try {
            $user = User::where('email', $email)->firstOrFail();
            $otpService = new OtpService();
            $otpService->generateAndSendOtp($user);

            return back()->with('success', 'OTP resent to your email!');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Failed to resend OTP: ' . $e->getMessage()]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'email' => 'required|email'
        ]);

        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $otpService = new OtpService();

            if ($otpService->verifyOtp($user, $request->otp)) {
                // Clear OTP data
                $user->update([
                    'otp' => null,
                    'otp_expires_at' => null,
                    'otp_attempts' => 0
                ]);

                // FINALLY LOGIN THE USER HERE
                Auth::login($user, $request->remember ?? false);
                event(new UserRegistered($user));

                return redirect()->route('home')
                    ->with('success', 'Login successful!');
            }
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['otp' => $e->getMessage()]);
        }
    }
}
