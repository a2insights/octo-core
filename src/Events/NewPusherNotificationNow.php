<?php

namespace Octo\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewPusherNotificationNow extends NewPusherNotification implements ShouldBroadcastNow
{

}
