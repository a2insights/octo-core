<?php

namespace Octo\System;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Octo\System\Http\Livewire\ListUsers;
use Octo\System\Http\Livewire\SiteFooter;
use Octo\System\Http\Livewire\SiteInfo;
use Octo\System\Http\Livewire\SiteSection;
use Octo\System\Http\Livewire\SiteSections;
use Octo\System\Http\Livewire\SwitchDashboard;

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        Livewire::component('switch-dashboard', SwitchDashboard::class);
        Livewire::component('octo-system-list-users', ListUsers::class);
        Livewire::component('octo-system-site-info', SiteInfo::class);
        Livewire::component('octo-system-site-footer', SiteFooter::class);
        Livewire::component('octo-system-site-section', SiteSection::class);
        Livewire::component('octo-system-site-sections', SiteSections::class);
    }
}
