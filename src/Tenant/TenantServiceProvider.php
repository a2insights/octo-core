<?php

namespace Octo\Tenant;

use App\Models\Company;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TenantServiceProvider extends PackageServiceProvider
{
    public function bootingPackage(): void {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->simple()
                ->visible(fn (): bool => auth()->user()?->hasAnyRole([
                    'super_admin',
                ]));
        });

        Company::created(function (Company $company) {
            $company->initialize();

            $cachePath = storage_path('framework/cache');

            if (! is_dir($cachePath)) {
                if (! mkdir($cachePath, 0777, true) && ! is_dir($cachePath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $cachePath));
                }
            }

            $company->end();
        });
    }

    public function configurePackage(Package $package): void
    {
        $package->name('octo.user');
    }
}
