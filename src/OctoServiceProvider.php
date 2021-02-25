<?php

namespace Octo;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Octo\Resources\Components\NavMaterial;
use Octo\Resources\Components\SidebarMaterial;
use Octo\Resources\Components\CardMaterial;
use Octo\Resources\Components\CounterMaterial;
use Octo\Resources\Components\TableComponent;
use Octo\Resources\Components\tailwind\NavTailwind;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/octo.php' => config_path('octo.php'),
        ], 'octo/config');

        $this->loadViewsFrom(__DIR__.'/views' , 'octo');

        Blade::component('octo-table', TableComponent::class);

        Blade::component('octo-nav-material', NavMaterial::class);

        Blade::component('octo-sidebar-material', SidebarMaterial::class);

        Blade::component('octo-card-material', CardMaterial::class);

        Blade::component('octo-counter-material', CounterMaterial::class);

        Blade::component('octo-tailwind-sidebar', NavTailwind::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/octo.php', 'octo'
        );
    }
}
