<?php

namespace Octo\Marketing\Filament\Contact;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Tables\Actions\LinkAction;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Octo\Marketing\Filament\Contact\Pages\CreateContact;
use Octo\Marketing\Filament\Contact\Pages\EditContact;
use Octo\Marketing\Filament\Contact\Pages\ListContacts;
use Octo\Marketing\Models\Contact;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Contacts';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema(Card::class))
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
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
                SpatieTagsColumn::make('tags')
                    ->type('contacts.tags'),
                BadgeColumn::make('status')
                    ->getStateUsing(fn ($record): ?string => $record->status ? 'active' : 'inactive')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),

            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        true => 'active',
                        false => 'inactive',
                    ]),
                MultiSelectFilter::make('tags')
                    ->relationship('tags', 'name'),

            ])->pushActions([
                LinkAction::make('delete')
                    ->action(fn ($record) => $record->delete())
                    ->requiresConfirmation()
                    ->color('danger'),
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
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(string $layout = Grid::class): array
    {
        return [
            Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn ($state, callable $set) => $set('email', "{$state}@example.com")),
                            DatePicker::make('birthday')
                                ->label('Birthday'),
                            TextInput::make('email')
                                ->email()
                                ->columnSpan([
                                    'sm' => 2,
                                ]),
                            $layout::make()
                                ->schema([
                                    TextInput::make('phone_number')
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state, callable $set) => $state ?? $set('phone_number_is_whatsapp', false))
                                        ->tel(),
                                    Checkbox::make('phone_number_is_whatsapp')
                                        ->disabled(fn ($state, callable $get) => $get('phone_number') == ''),
                                ]),
                        ])
                        ->columns([
                            'sm' => 2,
                        ]),
                        $layout::make()
                            ->schema([
                                SpatieTagsInput::make('tags')
                                    ->type('contacts.tags'),
                            ])
                            ->columns(1),
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            Placeholder::make('Status'),
                            Group::make()
                                ->schema([
                                    Toggle::make('status')
                                        ->label('Active')
                                        ->helperText('This contact will be disabled for the other modules.')
                                        ->default(true),
                                ]),

                        ])
                        ->columns(1),
                    $layout::make()
                        ->schema([
                            Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (?Contact $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (?Contact $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ])
                        ->columns(1),
                ])
                ->columnSpan(1),
        ];
    }
}