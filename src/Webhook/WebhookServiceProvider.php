<?php

namespace A2insights\FilamentSaas\Webhook;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WebhookServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-saas.webhook');
    }
}
