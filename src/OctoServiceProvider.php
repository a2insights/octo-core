<?php

namespace Octo;

use Illuminate\Support\ServiceProvider;

class OctoServiceProvider extends ServiceProvider
{
    use ComponentsProvider;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/octo.php' => config_path('octo.php'),
        ], 'octo/config');

        $this->loadViewsFrom(__DIR__.'/views' , 'octo');

        $this->registerComponentsProviders();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/octo-core.php', 'octo-core'
        );
    }
}
