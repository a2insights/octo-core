<?php

namespace Octo;

use Octo\Events\NewPusherNotificationNow;
use Octo\Events\NewPusherNotificationQueued;

class Notification extends ObjectPrototype
{
    protected $attributes = ['title', 'description', 'route'];

    /**
     * Dispatch event to pusher
     *
     * @param $user
     * @return $this
     */
    public function pusher($user)
    {
        if (Features::sendsPusherNotifications()) {
            if (Features::sendsPusherQueuedNotifications()) {
                event(new NewPusherNotificationQueued($user, $this));
            }

            if (! Features::sendsPusherQueuedNotifications()) {
                event(new NewPusherNotificationNow($user, $this));
            }
        }

        return $this;
    }
}
