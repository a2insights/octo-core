<?php

namespace Octo\Billing;

use Illuminate\Support\ServiceProvider;
use Octo\Billing\Actions\HandleSubscriptions;
use Octo\Billing\BillingPortal;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        BillingPortal::dontProrateOnSwap();

        BillingPortal::handleSubscriptionsUsing(HandleSubscriptions::class);
    }
}
