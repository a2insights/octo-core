<?php

namespace Octo\Listeners;

use Illuminate\Auth\Events\Registered;
use Octo\Notifications\WelcomeUser;

class WelcomeUserNotification
{
    public function handle(Registered $event)
    {
        $event->user->notify(new WelcomeUser($event->user));
    }
}
