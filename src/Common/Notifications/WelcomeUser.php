<?php

namespace Octo\Common\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Octo\Concerns\ToSmsProvider;
use Octo\Route;

class WelcomeUser extends Notification
{
    use ToSmsProvider;

    public function via($notifiable)
    {
        return $this->to(['mail', 'database', 'sms']);
    }

    public function toSms($notifiable)
    {
        return "Hello {$notifiable->name} Welcome to the Octo. \n Login into your account ". route('login');
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Welcome {$notifiable->name}")
            ->greeting("Hello {$notifiable->name}.")
            ->line('Welcome to the Octo.')
            ->action('Login', route('login'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return (new \Octo\Notification([
            'title' => "Hello {$notifiable->name}",
            'description' => 'Welcome to the Octo. Thank you for using our application!',
            'route' => (new Route(['name' => 'dashboard']))
        ]))->toArray();
    }
}
