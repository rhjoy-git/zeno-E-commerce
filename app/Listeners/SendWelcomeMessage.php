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
    
    public function handle(UserRegistered $event): void
    {
        Log::info("WelcomeNotification dispatched for user: {$event->user->email}");
        $event->user->notify(new WelcomeNotification($event->user));
    }
}
