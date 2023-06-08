<?php

namespace Octo\Features\Filament\Pages;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Toggle;

class FeaturesPage extends PennantPage
{
    protected static string $settings = Settings::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'features';

    protected static ?string $title = 'Features';

    protected ?string $heading = 'Featuress';

    protected ?string $subheading = 'Manage your features.';

    protected function getRedirectUrl(): ?string
    {
        return '/dashboard/features';
    }

    protected function afterSave(): void
    {
    }

    protected function getFormSchema(): array
    {
        return [
            Fieldset::make('Style')
                ->schema([
                    Toggle::make('dark_mode')
                        ->hint('You can enable the toggle button for switching between light and dark mode.')
                        ->helperText('Caution: If you enable dark mode, your site will be displayed the toggle button for switching between light and dark mode.')
                        ->default(false),
                ])->columns(1),
            Fieldset::make('Authentication')
                ->schema([
                    Toggle::make('auth_registration')
                        ->label('Registration')
                        ->hint('You can disable registration to your site.')
                        ->helperText('Caution: If you disable registration, users will not be able to register to your site.'),
                    Toggle::make('auth_login')
                        ->label('Login')
                        ->hint('You can disable login to your site.')
                        ->helperText('Caution: If you disable login, users will not be able to login to your site.'),
                    Toggle::make('auth_2fa')
                        ->label('2FA')
                        ->hint('You can enable 2FA to your site.')
                        ->helperText('Caution: If you enable 2FA, users will can enable 2FA to their account.'),
                ])->columns(1),

        ];
    }
}
