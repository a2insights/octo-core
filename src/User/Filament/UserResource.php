<?php

namespace Octo\User\Filament;

use App\Models\User;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Octo\User\Filament\Pages\CreateUser;
use Octo\User\Filament\Pages\EditUser;
use Octo\User\Filament\Pages\ListUsers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name.' ('.$record->email.')';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema(Card::class))
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function getFormSchema(string $layout = Grid::class): array
    {
        $role = app(config('permission.models.role'));

        return [
            Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            TextInput::make('name')
                                ->autofocus()
                                ->required()
                                ->placeholder(__('Name')),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(static::$model, 'email', ignoreRecord: true)
                                ->placeholder(__('Email')),
                            TextInput::make('password')
                                ->password()
                                ->hidden(static function (?User $record): bool|null {
                                    return $record?->exists;
                                })
                                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                ->placeholder(__('Password')),
                            Select::make('roles')
                                ->relationship('roles', 'name')
                                ->preload()
                                ->multiple()
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::title($record->name))
                                ->required(),
                        ]),

                ])
                ->columnSpan(2),
            Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                            Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (?User $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            Placeholder::make('roles')
                                ->label('Roles')
                                ->content(fn (?User $record): string => $record ? $record->roles->map(fn ($role) => Str::title($role->name))->join(', ') : '-'),
                            Placeholder::make('email_verified_at')
                                ->label('Email verified at')
                                ->content(fn (?User $record): string => $record?->email_verified_at ? $record->email_verified_at->diffForHumans() : '-'),
                        ]),
                ])
                ->columnSpan(1),
        ];

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable('desc'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                ToggleIconColumn::make('email_verified_at')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->offColor('danger')
                    ->onColor('success')
                    ->alignCenter()
                    ->sortable()
                    ->updateStateUsing(fn ($state, Model $record) => $record->forceFill(['email_verified_at' => $state ? now() : null])->save())
                    ->disabled(fn ($record) => ! auth()->user()->hasRole('super_admin') || $record->hasRole('super_admin'))
                    ->hoverColor(fn (Model $record) => $record->email_verified_at ? 'danger' : 'success')
                    ->label('Email verified'),
                TagsColumn::make('roles')->separator(',')->getStateUsing(fn ($record) => $record->roles->map(fn ($role) => $role->name)->implode(', ')),
                TextColumn::make('created_at')
                    ->label('Created at')
                    ->sortable('desc'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                \Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter::make('created_at'),
                Tables\Filters\Filter::make('email_verified_at')->label('Not verified')->query(fn (Builder $query) => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                \XliteDev\FilamentImpersonate\Tables\Actions\ImpersonateAction::make()
                    ->visible(fn ($record) => auth()->user()->hasRole('super_admin') && ! $record->hasRole('super_admin'))
                    ->iconButton(),
                \Widiu7omo\FilamentBandel\Actions\BanAction::make()
                    ->visible(fn ($record) => auth()->user()->hasRole('super_admin') && ! $record->isBanned() && ! $record->hasRole('super_admin'))
                    ->iconButton(),
                \Widiu7omo\FilamentBandel\Actions\UnbanAction::make()
                    ->visible(fn ($record) => auth()->user()->hasRole('super_admin') && $record->isBanned() && ! $record->hasRole('super_admin'))
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => ! $record->is(auth()->user()) && ! $record->hasRole('super_admin'))
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => ! $record->is(auth()->user()) && ! $record->hasRole('super_admin'))
                    ->iconButton(),
                Tables\Actions\ForceDeleteAction::make()->iconButton()->visible(fn ($record) => ! $record->is(auth()->user()) && ! $record->hasRole('super_admin') && $record->trashed()),
                Tables\Actions\RestoreAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->action(fn (Collection $records) => $records->filter(fn ($record) => ! $record->is(auth()->user()) && ! $record->hasRole('super_admin'))->each->delete()),
                Tables\Actions\ForceDeleteBulkAction::make()->action(fn (Collection $records) => $records->filter(fn ($record) => ! $record->is(auth()->user()) && ! $record->hasRole('super_admin'))->each->forceDelete()),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
