<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class WelcomeAdminNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('email.welcome.subject'))
            ->greeting(__('email.greeting', ['name' => $notifiable->name]))
            ->line(__('email.welcome.admin.line_1'))
            ->line(__('email.welcome.admin.line_2'))
            ->line(__('email.welcome.admin.line_3'))
            ->action(
                __('email.welcome.admin.action'),
                URL::signedRoute('auth.welcome', ['user' => $notifiable])
            ) // TODO: Add URL
            ->line(__('email.welcome.admin.line_4'));
    }
}
