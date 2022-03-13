<?php

namespace Octo\Settings\Filament\Pages;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Octo\Settings\SystemSettings as SettingsSystemSettings;

class SystemSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'System';

    protected static string $settings = SettingsSystemSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Card::make([
                Toggle::make('show_notifications')
                    ->label('Show Notifications')
                    ->hint('Show notifications in the top right corner of the page.')
                    ->onIcon('heroicon-s-bell')
                    ->offIcon('heroicon-s-bell')
            ])
            ->columnSpan([
                'sm' => 1,
            ]),
        ];
    }
}
