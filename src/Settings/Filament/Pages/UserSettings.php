<?php

namespace Octo\Settings\Filament\Pages;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Octo\Settings\UserSettings as BUserSettings;

class UserSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = BUserSettings::class;

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
