<?php

namespace Octo\Tests\Feature\Billing;

use Illuminate\Support\ServiceProvider;
use Octo\Billing\BillingPortal;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'test');

        BillingPortal::handleSubscriptionsUsing(Actions\HandleSubscriptions::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
