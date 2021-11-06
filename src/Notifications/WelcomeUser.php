<?php

namespace Octo\Notifications;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Octo\Concerns\ToSmsProvider;
use Octo\Features;
use Octo\Route;

class WelcomeUser extends Notification
{
    use ToSmsProvider;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return $this->to(['mail', 'database', Features::sendsWelcomeUserSmsNotifications() ? 'sms' : null]);
    }

    public function toSms($notifiable)
    {
        return "Hello {$this->user->name} Welcome to the Octo. \n Login into your account ". route('login');
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Welcome {$this->user->name}")
            ->greeting("Hello {$this->user->name}.")
            ->line('Welcome to the Octo.')
            ->action('Login', route('login'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return (new \Octo\Notification([
            'title' => "Hello {$this->user->name}",
            'description' => 'Welcome to the Octo. Thank you for using our application!',
            'route' => (new Route(['name' => 'dashboard']))
        ]))->toArray();
    }
}
