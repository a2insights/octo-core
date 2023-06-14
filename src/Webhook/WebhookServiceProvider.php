<?php

namespace Octo\Middleware;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class WebhookServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('octo.webhook');
    }
}
