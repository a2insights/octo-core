<?php

namespace A2Insights\FilamentSaas\Features\Filament\Pages;

use A2Insights\FilamentSaas\Features\Features;
use A2Insights\FilamentSaas\FilamentSaas;
use A2Insights\FilamentSaas\Settings\reCAPTCHASettings;
use A2Insights\FilamentSaas\Settings\WebhooksSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\App;

class FeaturesPage extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = Features::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $slug = 'settings/features';

    public static function getNavigationGroup(): ?string
    {
        return __('filament-saas::default.settings.title');
    }

    public function getTitle(): string
    {
        return __('filament-saas::default.features.title');
    }

    public function getHeading(): string
    {
        return __('filament-saas::default.features.heading');
    }

    public function getSubheading(): ?string
    {
        return __('filament-saas::default.features.subheading') ?? null;
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-saas::default.features.title');
    }

    private function recaptcha()
    {
        return App::make(reCAPTCHASettings::class);
    }

    private function webhooks()
    {
        return App::make(WebhooksSettings::class);
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        // if ($data['recaptcha']) {
        //     $recaptchaSettings = $this->recaptcha();
        //     $recaptchaSettings->site_key = $data['recaptcha-site_key'];
        //     $recaptchaSettings->secret_key = $data['recaptcha-secret_key'];

        //     $recaptchaSettings->save();
        // }

        if ($data['webhooks']) {
            $webhooksSettings = $this->webhooks();
            $webhooksSettings->models = $data['webhooks-models'];
            $webhooksSettings->history = $data['webhooks-history'];
            $webhooksSettings->poll_interval = $data['webhooks-poll_interval'];

            $webhooksSettings->save();
        }

        cache()->forget('filament-saas.features');
        cache()->forget('filament-saas.settings');
        cache()->forget('filament-saas.webhooks');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $recaptchaSettings = $this->recaptcha();
        // $data['recaptcha-site_key'] = $recaptchaSettings->site_key;
        // $data['recaptcha-secret_key'] = $recaptchaSettings->secret_key;

        $webhooksSettings = $this->webhooks();
        $data['webhooks-models'] = $webhooksSettings->models;
        $data['webhooks-history'] = $webhooksSettings->history;
        $data['webhooks-poll_interval'] = $webhooksSettings->poll_interval;

        return $data;
    }

    protected function getFormSchema(): array
    {
        return [
            // TODO: dark_mode not work with hasnayeen themes
            // Fieldset::make('Style')
            //     ->schema([
            //         Toggle::make('dark_mode')
            //             ->hint('You can enable the toggle button for switching between light and dark mode.')
            //             ->helperText('Caution: If you enable dark mode, your site will be displayed the toggle button for switching between light and dark mode.')
            //             ->default(false),
            //     ])->columns(1),
            Fieldset::make(__('filament-saas::default.features.developer.webhooks.title'))
                ->schema([
                    Toggle::make('webhooks')
                        ->label(__('filament-saas::default.features.developer.webhooks.title'))
                        ->reactive()
                        ->helperText(__('filament-saas::default.features.developer.webhooks.help_text')),
                    Toggle::make('webhooks-history')
                        ->label(__('filament-saas::default.features.developer.webhooks.history.label'))
                        ->helperText(__('filament-saas::default.features.developer.webhooks.history.help_text'))
                        ->visible(fn ($state, callable $get) => $get('webhooks')),
                    TextInput::make('webhooks-poll_interval')
                        ->label(__('filament-saas::default.features.developer.webhooks.poll_interval.label'))
                        ->helperText(__('filament-saas::default.features.developer.webhooks.poll_interval.help_text'))
                        ->placeholder('10s')
                        ->visible(fn ($state, callable $get) => $get('webhooks')),
                    Select::make('webhooks-models')
                        ->label(__('filament-saas::default.features.developer.webhooks.models.label'))
                        ->helperText(__('filament-saas::default.features.developer.webhooks.models.help_text'))
                        ->multiple()
                        ->default([])
                        ->options([
                            FilamentSaas::getUserModel() => 'user',
                            \Cog\Laravel\Ban\Models\Ban::class => 'ban',
                            \HusamTariq\FilamentDatabaseSchedule\Models\Schedule::class => 'schedule',
                            \Spatie\LaravelSettings\Models\SettingsProperty::class => 'settings',
                            \Spatie\Permission\Models\Permission::class => 'permission',
                            \Spatie\Permission\Models\Role::class => 'role',
                            \Illuminate\Notifications\DatabaseNotification::class => 'notification',
                            \Laravel\Sanctum\PersonalAccessToken::class => 'personal_access_token',
                        ])
                        ->visible(fn ($state, callable $get) => $get('webhooks')),
                ])->columns(1),
            Fieldset::make('User')
                ->label(__('filament-saas::default.features.user.title'))
                ->schema([
                    Toggle::make('switch_language')
                        ->label(__('filament-saas::default.features.user.switch_language.label'))
                        ->helperText(__('filament-saas::default.features.user.switch_language.help_text')),
                    Toggle::make('user_phone')
                        ->label(__('filament-saas::default.features.user.phone.label'))
                        ->helperText(__('filament-saas::default.features.user.phone.help_text')),
                    Toggle::make('username')
                        ->label(__('filament-saas::default.features.user.username.label'))
                        ->helperText(__('filament-saas::default.features.user.username.help_text')),
                ])
                ->columns(1),
            Fieldset::make('Auth')
                ->label(__('filament-saas::default.features.auth.title'))
                ->schema([
                    Toggle::make('auth_registration')
                        ->label(__('filament-saas::default.features.auth.registration.label'))
                        ->helperText(__('filament-saas::default.features.auth.registration.help_text')),
                    //TODO: Make this configurable
                    /*  Toggle::make('auth_login')
                        ->label('Login')
                        ->hint('You can disable login to your site.')
                        ->helperText('Caution: If you disable login, users will not be able to login to your site.'), */
                    //TODO: Make this configurable
                    /*   Toggle::make('auth_2fa')
                        ->label('2FA')
                        ->hint('You can enable 2FA to your site.')
                        ->helperText('Caution: If you enable 2FA, users will can enable 2FA to their account.'), */
                    // TODO: Implement feature and Make this configurable
                    /*  Toggle::make('recaptcha')
                        ->label('reCAPTCHA')
                        ->reactive()
                        ->hint('You can enable reCAPTCHA to your site.')
                        ->helperText('Caution: If you enable reCAPTCHA, users will login with reCAPTCHA.'),
                    TextInput::make('recaptcha-site_key')
                        ->label('reCAPTCHA Site Key')
                        ->required(fn ($state, callable $get) => $get('recaptcha'))
                        ->visible(fn ($state, callable $get) => $get('recaptcha'))
                        ->hint('You can set reCAPTCHA site key to your site.'),
                    TextInput::make('recaptcha-secret_key')
                        ->label('reCAPTCHA Secret Key')
                        ->required(fn ($state, callable $get) => $get('recaptcha'))
                        ->visible(fn ($state, callable $get) => $get('recaptcha'))
                        ->hint('You can set reCAPTCHA secret key to your site.'), */
                ])->columns(1),
        ];
    }
}
