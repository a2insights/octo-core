<?php

namespace A2Insights\FilamentSaas\System;

use Illuminate\Support\Facades\App;
use Opcodes\LogViewer\Facades\LogViewer;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SystemServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-saas.system');
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        // TODO: In logger not will be set. Implement it
        // return if running in the console
        if (App::runningInConsole()) {
            return;
        }

        LogViewer::auth(fn ($request) => $request->user()?->hasRole('super_admin'));
    }
}
