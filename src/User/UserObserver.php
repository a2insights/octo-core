<?php

namespace Octo\User;

use App\Models\User;
use Octo\User\Stats\UserStats;

class UserObserver
{
    public function created(User $user)
    {
        UserStats::increase();
    }

    public function deleted(User $user)
    {
        UserStats::decrease();
    }
}
