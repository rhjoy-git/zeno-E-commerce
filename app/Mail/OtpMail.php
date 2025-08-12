<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\OtpService;
use Illuminate\Support\Facades\Log;
class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp, public User $user, public $token) {}

    public function build()
    {
        Log::info('OtpMail build data', [
            'token' => $this->token,
            'otp' => $this->otp,
            'user_id' => $this->user->id,
        ]);
        return $this->markdown('emails.otp')
            ->subject('Your ' . config('app.name') . ' Verification Code')
            ->with([
                'token' => $this->token,
                'otp' => $this->otp,
                'expires_at' => now()->addMinutes(OtpService::OTP_EXPIRE_MINUTES)->format('h:i A'),
                'user' => $this->user,
            ])
            ->text('emails.plain_text');
    }
}
