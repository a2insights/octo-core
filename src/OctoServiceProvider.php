<?php

namespace Octo;

use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Octo\Features\FeaturesServiceProvider;
use Octo\Firewall\FirewallServiceProvider;
use Octo\Settings\Settings;
use Octo\Settings\SettingsServiceProvider;
use Octo\User\UserServiceProvider;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/octo.php' => config_path('octo.php'),
        ], 'octo-config');

        $this->commands([
            Console\SetupDevCommand::class,
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/octo.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'octo');

        Filament::registerRenderHook(
            'footer.start',
            fn (): View => view('octo::admin.footer', app(Settings::class)->toArray())
        );
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/octo.php', 'octo');

        $this->app->register(SettingsServiceProvider::class);
        $this->app->register(FeaturesServiceProvider::class);
        $this->app->register(FirewallServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
    }
}
