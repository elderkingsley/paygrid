<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class WelcomeInviteNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        // Generate a secure password reset token
        $token = Password::createToken($notifiable);

        // This builds the URL to your standard Laravel password reset page
        $url = url(config('app.url') . route('password.reset', [
            'token' => $token,
            'email' => $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Welcome to ' . ($notifiable->organization->name ?? 'Paygrid'))
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('You have been invited to join the ' . ($notifiable->organization->name ?? 'company') . ' treasury team.')
            ->line('To get started, you need to secure your account by setting a password.')
            ->action('Set Your Password', $url)
            ->line('This invitation link will expire in 60 minutes.')
            ->line('If you were not expecting this invitation, no further action is required.');
    }
}
