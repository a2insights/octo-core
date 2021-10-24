<?php

namespace Octo\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WelcomeUserQueuedNotification extends WelcomeUserNotification implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue;

    public $tries = 7;
}
