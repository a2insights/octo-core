<?php

namespace Octo\Concerns;

trait HasRouteSmsProviders
{
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }

    public function routeNotificationForTwilio($notification)
    {
        return $this->phone_number;
    }
}
