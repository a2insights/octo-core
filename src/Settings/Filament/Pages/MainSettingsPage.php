<?php

namespace A2Insights\FilamentSaas\Settings\Filament\Pages;

use A2Insights\FilamentSaas\Settings\Settings;
use A2Insights\FilamentSaas\Settings\TermsSettings;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Intl\Timezones;
use Wiebenieuwenhuis\FilamentCodeEditor\Components\CodeEditor;

class MainSettingsPage extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $slug = 'settings/main';

    public static function getNavigationGroup(): ?string
    {
        return __('filament-saas::default.settings.title');
    }

    public function getTitle(): string
    {
        return __('filament-saas::default.settings.title');
    }

    public function getHeading(): string
    {
        return __('filament-saas::default.settings.heading');
    }

    public function getSubheading(): ?string
    {
        return __('filament-saas::default.settings.subheading') ?? null;
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-saas::default.settings.title');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $termsSettings = $this->terms();
        $data['terms-service'] = $termsSettings->service;
        $data['terms-privacy_policy'] = $termsSettings->privacy_policy;

        return $data;
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        if ($data['terms']) {
            $termsSettings = $this->terms();
            $termsSettings->service = $data['terms-service'];
            $termsSettings->privacy_policy = $data['terms-privacy_policy'];

            $termsSettings->save();
        }

        cache()->forget('filament-saas.features');
        cache()->forget('filament-saas.settings');
        cache()->forget('filament-saas.webhooks');
    }

    protected function getFormSchema(): array
    {
        $locales = collect(Locales::getNames())->mapWithKeys(fn ($name, $code) => [$code => Str::title($name)])->toArray();
        $timezones = collect(Timezones::getNames())->mapWithKeys(fn ($name, $code) => [$code => Str::title($name)])->toArray();

        return [
            Section::make(__('filament-saas::default.settings.seo.title'))
                ->description(__('filament-saas::default.settings.seo.subtitle'))
                ->schema([
                    TextInput::make('name')
                        ->label(__('filament-saas::default.settings.seo.name.label')),
                    TagsInput::make('keywords')
                        ->label(__('filament-saas::default.settings.seo.keywords.label'))
                        ->helperText(__('filament-saas::default.settings.seo.keywords.help_text'))
                        ->suggestions([
                            'tailwindcss',
                            'alpinejs',
                            'laravel',
                            'livewire',
                        ]),
                    Textarea::make('description')
                        ->label(__('filament-saas::default.settings.seo.description.label'))
                        ->helperText(__('filament-saas::default.settings.seo.description.help_text'))
                        ->rows(2),
                ])
                ->collapsed()
                ->columns(1),

            Section::make(__('filament-saas::default.settings.style.title'))
                ->description(__('filament-saas::default.settings.style.subtitle'))
                ->schema([
                    FileUpload::make('logo')
                        ->label(__('filament-saas::default.settings.style.logo.label'))
                        ->helperText(__('filament-saas::default.settings.style.logo.help_text'))
                        ->image()
                        ->directory('images')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return 'logo.'.$file->guessExtension();
                        }),
                    TextInput::make('logo_size')
                        ->label(__('filament-saas::default.settings.style.logo_size.label'))
                        ->helperText(__('filament-saas::default.settings.style.logo_size.help_text')),
                    FileUpload::make('favicon')
                        ->label(__('filament-saas::default.settings.style.favicon.label'))
                        ->helperText(__('filament-saas::default.settings.style.favicon.help_text'))
                        ->image()
                        ->directory('images')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return 'favicon.'.$file->guessExtension();
                        }),
                ])
                ->collapsed()
                ->columns(1),
            Section::make(__('filament-saas::default.settings.embed.title'))
                ->description(__('filament-saas::default.settings.embed.subtitle'))
                ->schema([
                    CodeEditor::make('head')
                        ->label(__('filament-saas::default.settings.embed.head.label'))
                        ->helperText(__('filament-saas::default.settings.embed.head.help_text')),
                ])
                ->collapsed()
                ->columns(1),
            Section::make(__('filament-saas::default.settings.terms_and_privacy_policy.title'))
                ->description(__('filament-saas::default.settings.terms_and_privacy_policy.subtitle'))
                ->schema([
                    Toggle::make('terms')
                        ->label(__('filament-saas::default.settings.terms_and_privacy_policy.title'))
                        ->reactive(),
                    MarkdownEditor::make('terms-service')
                        ->label(__('filament-saas::default.settings.terms_and_privacy_policy.terms.label'))
                        ->fileAttachmentsDisk(config('filament.default_filesystem_disk'))
                        ->fileAttachmentsVisibility('public')
                        ->visible(fn ($state, callable $get) => $get('terms')),
                    MarkdownEditor::make('terms-privacy_policy')
                        ->label(__('filament-saas::default.settings.terms_and_privacy_policy.privacy_policy.label'))
                        ->fileAttachmentsDisk(config('filament.default_filesystem_disk'))
                        ->fileAttachmentsVisibility('public')
                        ->visible(fn ($state, callable $get) => $get('terms')),
                ])
                ->collapsed()
                ->columns(1),
            Section::make(__('filament-saas::default.settings.security.title'))
                ->description(__('filament-saas::default.settings.security.subtitle'))
                ->schema([
                    TagsInput::make('restrict_ips')
                        ->label(__('filament-saas::default.settings.security.restrict_ips.label'))
                        ->helperText(__('filament-saas::default.settings.security.restrict_ips.help_text'))
                        ->suggestions([
                            request()->ip(),
                        ]),
                    Select::make('restrict_users')
                        ->label(__('filament-saas::default.settings.security.restrict_users.label'))
                        ->helperText(__('filament-saas::default.settings.security.restrict_users.help_text'))
                        ->multiple()
                        ->searchable()
                        ->options(fn () => User::all()->pluck('name', 'id'))
                        ->getSearchResultsUsing(fn (string $search) => User::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name),
                ])
                ->collapsed()
                ->columns(1),
            Section::make(__('filament-saas::default.settings.localization.title'))
                ->description(__('filament-saas::default.settings.localization.subtitle'))
                ->schema([
                    Select::make('timezone')
                        ->label(__('filament-saas::default.settings.localization.timezone.label'))
                        ->helperText(__('filament-saas::default.settings.localization.timezone.help_text', ['time' => now()->format('Y-m-d H:i:s')]))
                        ->options($timezones)
                        ->searchable(),
                    Select::make('locales')
                        ->label(__('filament-saas::default.settings.localization.locales.label'))
                        ->helperText(__('filament-saas::default.settings.localization.locales.help_text'))
                        ->multiple()
                        ->options($locales)
                        ->searchable(),
                    Select::make('locale')
                        ->label(__('filament-saas::default.settings.localization.locale.label'))
                        ->helperText(__('filament-saas::default.settings.localization.locale.help_text'))
                        ->options(collect(app(Settings::class)->locales)->mapWithKeys(fn ($locale) => [$locale => Str::title(Locales::getName($locale))])->toArray())
                        ->searchable()
                        ->dehydrateStateUsing(fn ($state) => ! in_array($state, app(Settings::class)->locales) ? app(Settings::class)->locales[0] : $state),
                ])
                ->collapsed()
                ->columns(1),
        ];
    }

    private function terms()
    {
        return App::make(TermsSettings::class);
    }
}
