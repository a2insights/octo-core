<?php

namespace Octo;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Octo\Billing\BillingServiceProvider;
use Octo\Common\CommonServiceProvider;
use Octo\Marketing\MarketingServiceProvider;
use Octo\System\SystemServiceProvider;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/octo.php' => config_path('octo.php'),
        ], 'octo-config');

        $this->commands([
            Console\SetupDemoCommand::class,
            Console\InstallCommand::class,
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/octo.php');

        Filament::serving(function (): void {
            Filament::registerTheme(mix('css/app.css'));

            Filament::registerNavigationGroups([
                'Marketing',
            ]);
        });
    }

    public function register()
    {
        $this->app->register(MarketingServiceProvider::class);
        $this->mergeConfigFrom(__DIR__.'/../config/octo.php', 'octo');
    }
}
