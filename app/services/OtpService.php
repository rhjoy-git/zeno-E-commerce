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

    public function generateAndSendOtp(User $user)
    {
        // Check if user is blocked
        if ($this->isUserBlocked($user)) {
            throw new Exception("Too many attempts. Try again after " . self::BLOCK_MINUTES . " minutes.");
        }

        $otp = rand(100000, 999999); // 6-digit OTP

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'otp_attempts' => 0 // Reset attempts on new OTP
        ]);

        Mail::to($user->email)->queue(new OtpMail($otp));

        return $otp;
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
            'otp_blocked_until' => null
        ]);
    }
    
}
