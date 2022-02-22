<?php
namespace Octo;

use Filament\PluginServiceProvider;
use Octo\Resources\Filament\Pages\UserSettings;
use Spatie\LaravelPackageTools\Package;

class FilamentProvider extends PluginServiceProvider
{
    protected array $pages = [
        UserSettings::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo');
    }
}
