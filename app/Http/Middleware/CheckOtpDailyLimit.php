<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\OtpService; 
use App\Models\User;

class CheckOtpDailyLimit
{
    public function handle($request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->otp_requests_today >= OtpService::MAX_DAILY_OTP) {
            return back()->with('error', "Maximum OTP requests reached for today.");
        }

        return $next($request);
    }
}
