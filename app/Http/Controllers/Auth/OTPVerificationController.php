<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Exception;

class OTPVerificationController extends Controller
{
    public function showOtpForm($email)
    {
        return view('auth.verify-otp', ['email' => $email]);
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
            // Check if user is blocked
            if ($otpService->verifyOtp($user, $request->otp)) {
                // Clear OTP data
                $user->update([
                    'otp' => null,
                    'otp_expires_at' => null,
                    'otp_attempts' => 0
                ]);

                // FINALLY LOGIN THE USER HERE
                Auth::login($user, $request->remember ?? false);

                return redirect()->route('dashboard')
                    ->with('success', 'Login successful!');
            }
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['otp' => $e->getMessage()]);
        }
    }
}
