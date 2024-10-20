<?php

namespace Octo\Tenant;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TenantServiceProvider extends PackageServiceProvider
{
    public function bootingPackage(): void {}

    public function configurePackage(Package $package): void
    {
        $package->name('octo.user');
    }
}
