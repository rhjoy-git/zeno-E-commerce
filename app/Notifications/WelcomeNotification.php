<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
        $this->onQueue('notifications');
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('Thank you for joining ' . config('app.name') . '. Your account is now active.')
            ->line('Explore our wide range of products and start shopping today!')
            ->action('Visit Dashboard', route('home'))
            ->line('If you have any questions, contact us at support@' . config('app.name') . '.');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'welcome',
            'message' => 'Welcome, ' . $this->user->name . '! Your account is ready.',
            'user_id' => $this->user->id,
            'url' => route('home'),
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
