<?php

namespace Octo\Firewall;

use Filament\PluginServiceProvider;
use Octo\Firewall\Filament\FirewallIpResource;
use Spatie\LaravelPackageTools\Package;

class FirewallServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        // FirewallIpResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo.firewall');
    }
}
