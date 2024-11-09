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

    protected static ?string $title = 'Main Settings';

    protected ?string $heading = 'Main Settings';

    protected ?string $subheading = 'Update your main settings.';

    protected function afterSave(): void
    {
        cache()->forget('filament-saas.features');
        cache()->forget('filament-saas.settings');
        cache()->forget('filament-saas.webhooks');
    }

    protected function getFormSchema(): array
    {
        $locales = collect(Locales::getNames())->mapWithKeys(fn ($name, $code) => [$code => Str::title($name)])->toArray();
        $timezones = collect(Timezones::getNames())->mapWithKeys(fn ($name, $code) => [$code => Str::title($name)])->toArray();

        return [
            Fieldset::make('Metadata')
                ->schema([
                    TextInput::make('name'),
                    TagsInput::make('keywords')->suggestions([
                        'tailwindcss',
                        'alpinejs',
                        'laravel',
                        'livewire',
                    ]),
                    Textarea::make('description')->rows(2),
                ])->columns(1),
            Fieldset::make('Style')
                ->schema([
                    FileUpload::make('logo')->image()->directory('images')->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return 'logo.'.$file->guessExtension();
                    }),
                    TextInput::make('logo_size')->hint('Example: 2rem'),
                    FileUpload::make('favicon')->image()->directory('images')->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return 'favicon.'.$file->guessExtension();
                    }),
                ])->columns(1),
            Fieldset::make('Security')
                ->schema([
                    TagsInput::make('restrict_ips')
                        ->hint('You can restrict access to your site by IP address.')
                        ->helperText('Caution: If you block your own IP address, you will be locked out of your site. And you will have to manually remove your IP address from the database or access from another IP address.')
                        ->suggestions([
                            request()->ip(),
                        ]),
                    Select::make('restrict_users')
                        ->multiple()
                        ->searchable()
                        ->hint('You can restrict access to your site by user.')
                        ->helperText('Caution: If you block your own user, you will be locked out of your site. And you will have to manually remove your user from the database or access from another user.')
                        ->options(fn () => User::all()->pluck('name', 'id'))
                        ->getSearchResultsUsing(fn (string $search) => User::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name),
                ])->columns(1),
            Fieldset::make('Localization')
                ->schema([
                    Select::make('timezone')
                        ->options($timezones)
                        ->searchable()
                        ->hint('You can set the timezone for your site.')
                        ->helperText('Current time is: '.now()->format('Y-m-d H:i:s')),
                    Select::make('locales')
                        ->multiple()
                        ->options($locales)
                        ->searchable()
                        ->hint('You can set the languages available for your site. But the user can change the language.')
                        ->helperText('Caution: If you change the languages availables, the users will lose the language they have set.'),
                    Select::make('locale')
                        ->options(collect(app(Settings::class)->locales)->mapWithKeys(fn ($locale) => [$locale => Str::title(Locales::getName($locale))])->toArray())
                        ->searchable()
                        ->hint('You can set the default locale for your site. But the user can change the locale.')
                        ->helperText('Caution: If you change the locale, the locale will be displayed according to the locale you set.')
                        ->dehydrateStateUsing(fn ($state) => ! in_array($state, app(Settings::class)->locales) ? app(Settings::class)->locales[0] : $state),
                ])->columns(1),
        ];
    }
}
