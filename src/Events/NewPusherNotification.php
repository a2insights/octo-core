<?php

namespace Octo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Octo\Notification;

class NewPusherNotification
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $user;
    public $notification;

    public function __construct(User $user, Notification $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user-notification.'.$this->user->id);
    }

    public function broadcastAs()
    {
        return 'Octo\\Events\\NewPusherNotification';
    }
}
