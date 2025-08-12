<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\WelcomeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;

    public function handle(UserRegistered $event): void
    {
        if (!$event->user->email_verified_at) {
            Log::warning('UserRegistered event fired for unverified user: ' . $event->user->id);
            return;
        }

        try {
            $event->user->notify(new WelcomeNotification($event->user));
        } catch (\Exception $e) {
            Log::error('Failed to send welcome notification for user ' . $event->user->id . ': ' . $e->getMessage());
            $this->release(60);
        }
    }
}