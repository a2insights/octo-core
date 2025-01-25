<?php

declare(strict_types=1);

namespace A2Insights\FilamentSaas\Tenant;

use A2Insights\FilamentSaas\Facades\FilamentSaas;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TenantServiceProvider extends PackageServiceProvider
{
    public function bootingPackage(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->simple()
                ->visible(fn (): bool => auth()->user()?->hasAnyRole([
                    'super_admin',
                ]));
        });

        if (! class_exists(FilamentSaas::getCompanyModel())) {
            return;
        }

        FilamentSaas::getCompanyModel()::created(function (Model $company) {
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
        $package->name('filament-saas.user');
    }
}
