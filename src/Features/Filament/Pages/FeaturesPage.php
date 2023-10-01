<?php

namespace Octo\Features\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\App;
use Octo\Features\Features;
use Octo\Octo;
use Octo\Settings\reCAPTCHASettings;
use Octo\Settings\TermsSettings;
use Octo\Settings\WebhooksSettings;

class FeaturesPage extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = Features::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $slug = 'features';

    protected static ?string $title = 'Features';

    protected ?string $heading = 'Featuress';

    protected ?string $subheading = 'Manage your features.';

    private function recaptcha()
    {
        return App::make(reCAPTCHASettings::class);
    }

    private function terms()
    {
        return App::make(TermsSettings::class);
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

        if ($data['terms']) {
            $termsSettings = $this->terms();
            $termsSettings->service = $data['terms-service'];
            $termsSettings->privacy_policy = $data['terms-privacy_policy'];

            $termsSettings->save();
        }

        if ($data['webhooks']) {
            $webhooksSettings = $this->webhooks();
            $webhooksSettings->models = $data['webhooks-models'];
            $webhooksSettings->history = $data['webhooks-history'];
            $webhooksSettings->poll_interval = $data['webhooks-poll_interval'];

            $webhooksSettings->save();
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // $recaptchaSettings = $this->recaptcha();
        // $data['recaptcha-site_key'] = $recaptchaSettings->site_key;
        // $data['recaptcha-secret_key'] = $recaptchaSettings->secret_key;

        $termsSettings = $this->terms();
        $data['terms-service'] = $termsSettings->service;
        $data['terms-privacy_policy'] = $termsSettings->privacy_policy;

        $webhooksSettings = $this->webhooks();
        $data['webhooks-models'] = $webhooksSettings->models;
        $data['webhooks-history'] = $webhooksSettings->history;
        $data['webhooks-poll_interval'] = $webhooksSettings->poll_interval;

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
            Fieldset::make('Developer')
                ->schema([
                    Toggle::make('webhooks')
                        ->label('Webhooks')
                        ->reactive()
                        ->hint('You can enable webhooks to your site.')
                        ->helperText('Caution: If you enable webhooks, users will can enable webhooks to their account.'),
                    Toggle::make('webhooks-history')
                        ->label('Webhooks History')
                        ->hint('You can enable webhooks history')
                        ->visible(fn ($state, callable $get) => $get('webhooks'))
                        ->helperText('This is anable the webhooks logs.'),
                    TextInput::make('webhooks-poll_interval')
                        ->label('Webhooks poll interval')
                        ->hint('You can enable webhooks poll interval')
                        ->placeholder('10s')
                        ->visible(fn ($state, callable $get) => $get('webhooks'))
                        ->helperText('The webhook pages will refresh every time the poll interval is reached. If not set, the page will not refresh automatically.'),
                    Select::make('webhooks-models')
                        ->label('Webhooks Models available')
                        ->multiple()
                        ->options([
                            Octo::getUserModel() => 'user',
                            \Cog\Laravel\Ban\Models\Ban::class => 'ban',
                            \HusamTariq\FilamentDatabaseSchedule\Models\Schedule::class => 'schedule',
                            \Spatie\LaravelSettings\Models\SettingsProperty::class => 'settings',
                            \Spatie\Permission\Models\Permission::class => 'permission',
                            \Spatie\Permission\Models\Role::class => 'role',
                            \Illuminate\Notifications\DatabaseNotification::class => 'notification',
                            \Laravel\Sanctum\PersonalAccessToken::class => 'personal_access_token',
                        ])
                        ->visible(fn ($state, callable $get) => $get('webhooks'))
                        ->hint('You can configure webhooks models available to your site.'),
                ])->columns(1),
            Fieldset::make('Authentication')
                ->schema([
                    //TODO: Make this configurable
                    /*  Toggle::make('auth_registration')
                        ->label('Registration')
                        ->hint('You can disable registration to your site.')
                        ->helperText('Caution: If you disable registration, users will not be able to register to your site.'), */
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
                    Toggle::make('terms')
                        ->label('Terms of Service and Privacy Policy')
                        ->reactive()
                        ->hint('You can enable terms of service to your site.')
                        ->helperText('Caution: If you enable terms of service, users will required to accept terms of service in registration.'),
                    MarkdownEditor::make('terms-service')
                        ->fileAttachmentsDisk('public') // TODO: Make this configurable
                        ->fileAttachmentsVisibility('public') // TODO: Make this configurable
                        ->visible(fn ($state, callable $get) => $get('terms')),
                    MarkdownEditor::make('terms-privacy_policy')
                        ->fileAttachmentsDisk('public') // TODO: Make this configurable
                        ->fileAttachmentsVisibility('public') // TODO: Make this configurable
                        ->visible(fn ($state, callable $get) => $get('terms')),
                ])->columns(1),
        ];
    }
}
