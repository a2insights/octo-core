<?php

namespace Octo;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Octo\Resources\Components\material\CardMaterial;
use Octo\Resources\Components\material\CounterMaterial;
use Octo\Resources\Components\material\NavMaterial;
use Octo\Resources\Components\material\SidebarMaterial;
use Octo\Resources\Components\tailwind\SidebarTailwind;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/octo.php' => config_path('octo.php'),
        ], 'octo/config');

        $this->loadViewsFrom(__DIR__.'/views' , 'octo');

        Blade::component('octo-material-nav', NavMaterial::class);

        Blade::component('octo-material-sidebar', SidebarMaterial::class);

        Blade::component('octo-material-card', CardMaterial::class);

        Blade::component('octo-material-counter', CounterMaterial::class);

        Blade::component('octo-tailwind-sidebar', SidebarTailwind::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/octo.php', 'octo'
        );
    }
}
