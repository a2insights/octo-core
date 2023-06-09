<?php

namespace Octo\Firewall;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FirewallServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('octo.firewall');
    }
}
