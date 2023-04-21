<?php

namespace Octo;

use Illuminate\Support\ServiceProvider;

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
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/octo.php', 'octo');
    }
}
