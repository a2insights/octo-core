<?php
namespace Octo\Settings;

use Filament\PluginServiceProvider;
use Octo\Settings\Filament\Pages\SystemSettings;
use Spatie\LaravelPackageTools\Package;

class SettingServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        SystemSettings::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo');
    }
}
