<?php

namespace Octo\User;

use App\Models\User;
use Octo\User\Stats\UserStats;

class UserObserver
{
    public function created(User $user)
    {
        UserStats::increase(1, $user->created_at);
    }

    public function deleted(User $user)
    {
        UserStats::decrease();
    }

    public function restored(User $user)
    {
        UserStats::increase();
    }
}
