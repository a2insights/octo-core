<?php

namespace Octo;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Octo\Features\FeaturesServiceProvider;
use Octo\Firewall\FirewallServiceProvider;
use Octo\Middleware\MiddlewareServiceProvider;
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

        Filament::serving(function () {
            $navigation = [
                'super_admin' => [
                    [
                        NavigationItem::make('Logs')
                            ->url(config('log-viewer.route_path'))
                            ->icon('heroicon-o-clipboard-list')
                            ->group('System'),
                    ],
                ],
            ];

            $isSuperAdmin = auth()?->user()?->hasRole('super_admin');

            collect($navigation['super_admin'])->each(fn ($items) => $isSuperAdmin ? Filament::registerNavigationItems($items) : null);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/octo.php', 'octo');

        $this->app->register(SettingsServiceProvider::class);
        $this->app->register(FeaturesServiceProvider::class);
        $this->app->register(FirewallServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
    }
}
