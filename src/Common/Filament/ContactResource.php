<?php

namespace Octo\Common\Filament;

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
use Octo\Common\Contact;
use Octo\Common\Filament\Pages\CreateContact;
use Octo\Common\Filament\Pages\EditContact;
use Octo\Common\Filament\Pages\ListContacts;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                ->sortable(),
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
             TextColumn::make('email')
                ->searchable()
                ->sortable(),
           BadgeColumn::make('status')
                ->getStateUsing(fn ($record): ?string => $record->status ? 'active' : 'inactive')
                ->colors([
                    'success' => 'active',
                    'danger' => 'inactive',
                ]),

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
                            TextInput::make('phone')
                                ->tel(),
                            TextInput::make('email')
                                ->email()
                                ->columnSpan([
                                    'sm' => 2,
                                ]),
                            $layout::make()
                                ->schema([
                                    TextInput::make('mobile_phone')
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $state ?? $set('mobile_phone_is_whatsapp', false))
                                    ->tel(),
                                    Checkbox::make('mobile_phone_is_whatsapp')->disabled(fn ($state, callable $get) => $get('mobile_phone') == ''),
                                ]),
                            MarkdownEditor::make('properties.description')
                                ->columnSpan([
                                    'sm' => 2,
                                ]),
                        ])->columns([
                            'sm' => 2,
                        ]),

                ])->columnSpan([
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
                            DatePicker::make('birthday')
                                ->label('Birthday'),
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
