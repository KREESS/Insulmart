<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Atur Ulang Kata Sandi Anda')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi Anda.')
            ->action('Atur Ulang Kata Sandi', url(config('app.url') . route('password.reset', $this->token, false)))
            ->line('Jika Anda tidak meminta ini, Anda dapat mengabaikan email ini.')
            ->salutation('Salam, Tim Insulmart');
    }
}
