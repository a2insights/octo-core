<?php

namespace Octo\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Queue\InteractsWithQueue;

class VerifyEmailQueued extends VerifyEmail implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue;
}
