<?php

namespace Octo\Settings\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Livewire\TemporaryUploadedFile;
use Octo\Settings\Settings;

class MainSettingsPage extends SettingsPage
{
    protected static string $settings = Settings::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'settings/main';

    protected static ?string $title = 'Main Settings';

    protected ?string $heading = 'Main Settings';

    protected ?string $subheading = 'Update your main settings.';

    protected function getFormSchema(): array
    {

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
                    Toggle::make('dark_mode')->default(false),
                    FileUpload::make('logo')->image()->directory('images')->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return 'logo.'.$file->guessExtension();
                    }),
                    FileUpload::make('favicon')->image()->directory('images')->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return 'favicon.'.$file->guessExtension();
                    }),
                ])->columns(1),
            Fieldset::make('Authentication')
                ->schema([
                    Toggle::make('auth_registration')->default(true),
                    Toggle::make('auth_login')->default(true),
                ])->columns(1),
            Fieldset::make('Security')
                ->schema([
                    TagsInput::make('restrict_ips')->suggestions([
                        request()->ip(),
                    ]),
                    Select::make('restrict_users')
                        ->multiple()
                        ->searchable()
                        ->options(User::all()->pluck('name', 'id'))
                        ->getSearchResultsUsing(fn (string $search) => User::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn ($value): ?string => User::find(2)?->name),
                ])->columns(1),
        ];
    }
}
