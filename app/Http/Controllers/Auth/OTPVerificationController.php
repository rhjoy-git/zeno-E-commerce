<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class OTPVerificationController extends Controller
{

    public function showOtpForm(string $token)
    {
        $user = User::where('otp_verification_token', $token)
            ->select('id', 'email', 'otp', 'otp_expires_at', 'otp_blocked_until', 'email_verified_at')
            ->first();

        if (!$user) {
            Log::warning('Invalid OTP verification token: ' . $token);
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('error', 'Email already verified.');
        }

        if ($this->isUserBlocked($user)) {
            $remaining = now()->diffInMinutes($user->otp_blocked_until);
            return redirect()->route('login')->with('error', "Too many attempts. Try again in {$remaining} minutes.");
        }

        return view('auth.verify-otp', [
            'user' => $user,
            'token' => $token,
            'remainingSeconds' => $user->otp_expires_at ? now()->diffInSeconds($user->otp_expires_at) : 0,
        ]);
    }

    public function resendOtp(Request $request, string $token)
    {
        try {
            $user = User::where('otp_verification_token', $token)->first();
            if (!$user) {
                Log::warning('Invalid OTP resend token: ' . $token);
                return redirect()->route('register')->with('error', 'Invalid verification token.');
            }

            $otpService = new OtpService();
            $newToken = $otpService->generateAndSendOtp($user);
            return redirect()->route('otp.verify', ['token' => $newToken])
                ->with('success', 'OTP resent to your email!');
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP for token ' . $token . ': ' . $e->getMessage());
            return redirect()->route('otp.verify', ['token' => $token])
                ->withErrors(['otp' => 'Failed to resend OTP. Please try again.']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'token' => 'required|string',
        ]);

        try {
            $user = User::where('otp_verification_token', $request->token)->first();
            if (!$user) {
                Log::warning('Invalid OTP verification token: ' . $request->token);
                return back()->withInput()->withErrors(['otp' => 'Invalid verification token.']);
            }

            $otpService = new OtpService();
            if ($otpService->verifyOtp($user, $request->otp, $request->token)) {
                Auth::login($user, $request->remember ?? false);
                event(new UserRegistered($user));
                return redirect()->route('home')
                    ->with('success', 'Registration successful! Welcome!');
            }
        } catch (\Exception $e) {
            Log::error('OTP verification failed for token ' . $request->token . ': ' . $e->getMessage());
            return back()->withInput()->withErrors(['otp' => $e->getMessage()]);
        }
    }

    protected function isUserBlocked(User $user): bool
    {
        return $user->otp_blocked_until && now()->lt($user->otp_blocked_until);
    }
}
