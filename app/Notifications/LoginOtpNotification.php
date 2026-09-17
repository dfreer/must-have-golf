<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginOtpNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $code) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Must Have Golf login code')
            ->greeting('Your login code')
            ->line("Use {$this->code} to sign in to Must Have Golf.")
            ->line('This code expires in 10 minutes and can only be used once.')
            ->line('If you did not request this code, you can ignore this email.');
    }
}
