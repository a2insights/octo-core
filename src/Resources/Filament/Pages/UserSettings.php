<?php

namespace Octo\Resources\Filament\Pages;

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
            Toggle::make('show_notifications')
                ->onIcon('heroicon-s-bell')
                ->offIcon('heroicon-s-bell')
        ];
    }
}
