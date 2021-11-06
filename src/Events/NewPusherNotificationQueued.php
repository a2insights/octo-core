<?php

namespace Octo\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewPusherNotificationQueued extends NewPusherNotification implements ShouldBroadcast
{

}
