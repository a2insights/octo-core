<?php

namespace Octo\Features\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Octo\Features\Features;
use Octo\Settings\reCAPTCHASettings;

class FeaturesPage extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = Features::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-grid-add';

    protected static ?string $navigationGroup = 'System';

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
        Artisan::call('route:clear');

        $data = $this->form->getState();

        if ($data['recaptcha']) {
            $recaptchaSettings = App::make(reCAPTCHASettings::class);

            $recaptchaSettings->site_key = $data['recaptcha-site_key'];
            $recaptchaSettings->secret_key = $data['recaptcha-secret_key'];

            $recaptchaSettings->save();
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $recaptchaSettings = App::make(reCAPTCHASettings::class);

        $data['recaptcha-site_key'] = $recaptchaSettings->site_key;
        $data['recaptcha-secret_key'] = $recaptchaSettings->secret_key;

        return $data;
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
                    Toggle::make('recaptcha')
                        ->label('reCAPTCHA')
                        ->reactive()
                        ->hint('You can enable reCAPTCHA to your site.')
                        ->helperText('Caution: If you enable reCAPTCHA, users will login with reCAPTCHA.'),
                    TextInput::make('recaptcha-site_key')
                        ->label('reCAPTCHA Site Key')
                        ->visible(fn ($state, callable $get) => $get('recaptcha'))
                        ->hint('You can set reCAPTCHA site key to your site.'),
                    TextInput::make('recaptcha-secret_key')
                        ->label('reCAPTCHA Secret Key')
                        ->visible(fn ($state, callable $get) => $get('recaptcha'))
                        ->hint('You can set reCAPTCHA secret key to your site.'),
                ])->columns(1),
            Fieldset::make('Developer')
                ->schema([
                    Toggle::make('webhooks')
                        ->label('Webhooks')
                        ->hint('You can enable webhooks to your site.')
                        ->helperText('Caution: If you enable webhooks, users will can enable webhooks to their account.'),
                ])->columns(1),
        ];
    }
}
