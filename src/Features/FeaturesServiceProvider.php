<?php

namespace Octo\Features;

use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use Octo\Features\Filament\Pages\FeaturesPage;
use Spatie\LaravelPackageTools\Package;

class FeaturesServiceProvider extends PluginServiceProvider
{
    protected array $pages = [
        FeaturesPage::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('octo.features');
    }

    protected function getUserMenuItems(): array
    {
        return [
            UserMenuItem::make()
                ->label('Features')
                ->url('/dashboard/features')
                ->icon('heroicon-o-annotation'),
        ];
    }

    public function packageBooted(): void
    {
        parent::packageBooted();
    }
}
