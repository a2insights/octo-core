<?php

namespace Octo\Concerns;

use Illuminate\Auth\Notifications\VerifyEmail;
use Octo\Features;
use Octo\Notifications\VerifyEmailQueued;

trait MustVerifyEmailQueued
{
    public function sendEmailVerificationNotification()
    {
        if (Features::queuedWelcomeUserNotifications()) {
            $this->notify(new VerifyEmailQueued);
        } else {
            $this->notify(new VerifyEmail);
        }
    }
}
