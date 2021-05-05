<?php

namespace Octo;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Octo\Http\Livewire\GuestNavigationMenu;
use Octo\Resources\Components\Sidebar;

class OctoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/octo.php' => config_path('octo.php'),
        ], 'octo/config');

        $this->loadViewsFrom(__DIR__.'/views' , 'octo');

        Blade::component('octo::sidebar', Sidebar::class);
        Blade::component('octo::components.hero','octo-hero');
        Blade::component('octo::components.tile','octo-tile');
        Blade::component('octo::layouts.guest','octo-guest-layout');
        Blade::component('octo::layouts.app','octo-app-layout');
        Livewire::component('octo::guest-navigation-menu', GuestNavigationMenu::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/octo-core.php', 'octo-core'
        );
    }
}
