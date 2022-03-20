<?php

namespace Octo\Marketing\Filament\Campaign;

use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\LinkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Filament\Campaign\Pages\CreateCampaign;
use Octo\Marketing\Filament\Campaign\Pages\EditCampaign;
use Octo\Marketing\Filament\Campaign\Pages\ListCampaigns;
use Octo\Marketing\Filament\Campaign\Pages\ViewCampaign;
use Octo\Marketing\Models\Campaign;
use Octo\Marketing\Models\Contact;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Campaigns';

    protected static ?int $navigationSort = 1;

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
                BadgeColumn::make('status')
                    ->getStateUsing(fn ($record): ?string => $record->status)
                    ->colors(CampaignStatus::colors()),

            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(CampaignStatus::toArray()),
            ])->pushActions([
                LinkAction::make('delete')
                    ->action(fn ($record) =>  $record->isDraft() ? $record->delete() : null)
                    ->disabled(fn ($record) => !$record->isDraft())
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
            'index' => ListCampaigns::route('/'),
            'create' => CreateCampaign::route('/create'),
            'edit' => EditCampaign::route('/{record}/edit'),
            'view' => ViewCampaign::route('/{record}'),
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
                                ->columnSpan([
                                    'sm' => 2,
                                ]),
                            Textarea::make('message')
                                ->required()
                                ->columnSpan([
                                    'sm' => 2,
                                ]),
                            BelongsToManyMultiSelect::make('targets')
                                ->relationship('contacts', 'name')
                                ->columns(2)
                                ->required()
                                ->options(Contact::all()->pluck('name', 'id'))
                                ->columnSpan([
                                    'sm' => 2,
                                ])
                        ]),
                ])
                ->columnSpan([
                    'sm' => 2,
                ]),
            Group::make()
                ->schema([
                    $layout::make()
                        ->schema([
                            Group::make()
                                ->schema([
                                    CheckboxList::make('properties.channels')
                                        ->label('Channels')
                                        ->required()
                                        ->default(['email'])
                                        ->options([
                                            'email' => 'Email',
                                            'sms' => 'SMS',
                                        ]),
                                ]),

                        ])
                        ->columns(1),
                    $layout::make()
                        ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (?Campaign $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (?Campaign $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ])
                        ->columns(1),
                ])
                ->columnSpan(1),
        ];
    }
}
