<?php

namespace Octo\Settings;

use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Octo\Settings\Filament\Pages\MainSettingsPage;
use Spatie\LaravelPackageTools\Package;

class SettingsServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        MainSettingsPage::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo.settings');
    }

    protected function getUserMenuItems(): array
    {
        return [
            UserMenuItem::make()
                ->label('Settings')
                ->url('/settings/main')
                ->icon('heroicon-s-cog'),
        ];
    }
}
