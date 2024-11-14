<?php

namespace A2Insights\FilamentSaas\Settings\Filament\Pages;

use A2Insights\FilamentSaas\Settings\Settings;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Intl\Timezones;

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

    protected function afterSave(): void
    {
        cache()->forget('filament-saas.features');
        cache()->forget('filament-saas.settings');
        cache()->forget('filament-saas.webhooks');
    }

    protected function getFormSchema(): array
    {
        $locales = collect(Locales::getNames())->mapWithKeys(fn($name, $code) => [$code => Str::title($name)])->toArray();
        $timezones = collect(Timezones::getNames())->mapWithKeys(fn($name, $code) => [$code => Str::title($name)])->toArray();

        return [
            Fieldset::make('SEO')
                ->label(__('filament-saas::default.settings.seo.title'))
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
                ])->columns(1),
            Fieldset::make('Style')
                ->label(__('filament-saas::default.settings.style.title'))
                ->schema([
                    FileUpload::make('logo')
                        ->label(__('filament-saas::default.settings.style.logo.label'))
                        ->helperText(__('filament-saas::default.settings.style.logo.help_text'))
                        ->image()
                        ->directory('images')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return 'logo.' . $file->guessExtension();
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
                            return 'favicon.' . $file->guessExtension();
                        }),
                ])->columns(1),
            Fieldset::make('Security')
                ->label(__('filament-saas::default.settings.security.title'))
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
                        ->options(fn() => User::all()->pluck('name', 'id'))
                        ->getSearchResultsUsing(fn(string $search) => User::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->name),
                ])->columns(1),
            Fieldset::make('Localization')
                ->schema([
                    Select::make('timezone')
                        ->label(__('filament-saas::default.settings.localization.timezone.label'))
                        ->helperText(__('filament-saas::default.settings.localization.timezone.help_text', ['time' =>  now()->format('Y-m-d H:i:s')]))
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
                        ->options(collect(app(Settings::class)->locales)->mapWithKeys(fn($locale) => [$locale => Str::title(Locales::getName($locale))])->toArray())
                        ->searchable()
                        ->dehydrateStateUsing(fn($state) => ! in_array($state, app(Settings::class)->locales) ? app(Settings::class)->locales[0] : $state),
                ])->columns(1),
        ];
    }
}
