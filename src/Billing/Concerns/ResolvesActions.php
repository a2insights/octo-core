<?php

namespace Octo\Billing\Concerns;

use Octo\Billing\Contracts\HandleSubscriptions;

trait ResolvesActions
{
    /**
     * Set the class to resolve the subscription actions.
     *
     * @param  string  $class
     * @return void
     */
    public static function handleSubscriptionsUsing(string $class)
    {
        app()->singleton(HandleSubscriptions::class, $class);
    }
}
