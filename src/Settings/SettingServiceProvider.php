<?php
namespace Octo\Settings;

use Filament\PluginServiceProvider;
use Octo\Settings\Filament\Pages\UserSettings;
use Spatie\LaravelPackageTools\Package;

class SettingServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        UserSettings::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo');
    }
}
