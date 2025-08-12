<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\OtpService;

class CheckOtpDailyLimit
{
    public function handle(Request $request, Closure $next)
    {
        $identifier = $request->email ?? $request->route('email') ?? $request->route('token');
        if ($identifier) {
            $user = User::where('email', $identifier)
                ->orWhere('otp_verification_token', $identifier)
                ->first();

            if (!$user) {
                Log::warning('No user found for OTP limit check with identifier: ' . $identifier);
                return redirect()->back()->withErrors(['otp' => 'Invalid user or token.']);
            }

            if ($user->otp_requests_today >= OtpService::MAX_DAILY_OTP) {
                Log::warning('OTP daily limit exceeded for user ' . $user->id);
                return redirect()->back()->withErrors(['otp' => 'Maximum OTP requests reached for today.']);
            }
        }
        return $next($request);
    }
}