<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Exception;

class OtpService
{
    const MAX_ATTEMPTS = 5;
    const BLOCK_MINUTES = 5;
    const MAX_DAILY_OTP = 5;
    private const OTP_EXPIRE_MINUTES = 3;

    public function generateAndSendOtp(User $user)
    {
        //   Check daily OTP limit
        $this->checkDailyOtpLimit($user);
        //  Check if user is blocked
        if ($this->isUserBlocked($user)) {
            $remaining = now()->diffInMinutes($user->otp_blocked_until);
            throw new Exception("Try again in {$remaining} minutes.");
        }
        //  Check if active OTP exists
        if ($this->hasActiveOtp($user)) {
            $remaining = now()->diffInSeconds($user->otp_expires_at);
            throw new Exception("Please wait until current OTP expires.");
        }
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(self::OTP_EXPIRE_MINUTES),
            'otp_attempts' => 0,
            'otp_requests_today' => $user->otp_requests_today + 1,
            'last_otp_request_date' => now()->toDateString()
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($otp));
    }

    protected function checkDailyOtpLimit(User $user)
    {
        if ($user->last_otp_request_date != today()->toDateString()) {
            $user->update([
                'otp_requests_today' => 0,
                'last_otp_request_date' => today()
            ]);
            return;
        }
        if ($user->otp_requests_today >= self::MAX_DAILY_OTP) {
            throw new Exception("Maximum OTP requests reached for today.");
        }
    }

    protected function hasActiveOtp(User $user)
    {
        return $user->otp_expires_at && now()->lt($user->otp_expires_at);
    }

    public function verifyOtp(User $user, $enteredOtp)
    {
        // Check if user is blocked
        if ($this->isUserBlocked($user)) {
            throw new Exception("Account temporarily blocked. Try again later.");
        }

        if ($user->otp_attempts >= self::MAX_ATTEMPTS) {
            $this->blockUser($user);
            throw new Exception("Too many attempts. Account blocked.");
        }

        $isValid = $user->otp === $enteredOtp &&
            Carbon::now()->lt($user->otp_expires_at);
        // Check if OTP is valid and not expired
        if (!$isValid) {
            $user->increment('otp_attempts');
            $remaining = self::MAX_ATTEMPTS - $user->otp_attempts;
            throw new Exception("Invalid OTP. {$remaining} attempts left.");
        }

        // Reset on success
        $this->resetAttempts($user);
        return true;
    }
    protected function isUserBlocked(User $user)
    {
        return $user->otp_blocked_until &&
            Carbon::now()->lt($user->otp_blocked_until);
    }

    protected function blockUser(User $user)
    {
        $user->update([
            'otp_blocked_until' => Carbon::now()->addMinutes(self::BLOCK_MINUTES)
        ]);
    }
    protected function resetAttempts(User $user)
    {
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
            'otp_blocked_until' => null,
            'email_verified_at' => now()
        ]);
    }
}
