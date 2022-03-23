<?php

namespace  Octo\Marketing\Filament\Campaign;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Models\CampaignContact;

class CampaignContactRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                Card::make()
                    ->schema([
                        TextInput::make('phone_number')
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $state ?? $set('phone_number_is_whatsapp', false))
                            ->tel(),
                        Checkbox::make('phone_number_is_whatsapp')
                            ->disabled(fn ($state, callable $get) => $get('phone_number') == ''),
                    ]),
                ]);
    }

    public static function attachForm(Form $form): Form
    {
        return $form
            ->schema([
                static::getAttachFormRecordSelect(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                SpatieTagsColumn::make('tags')
                    ->type('contacts.tags'),
            ]);
    }

    protected function canDelete(Model $record): bool
    {
        if (!$this->canRemove($record)) {
            return false;
        }

        return $this->can('delete', $record);
    }

    protected function canAttach(): bool
    {
        if ($this->ownerRecord->hasAnyStatus([
            CampaignStatus::DRAFT(),
            CampaignStatus::PAUSED(),
        ])) {
            return $this->can('attach');
        }

        return false;
    }

    protected function canCreate(): bool
    {
        if ($this->ownerRecord->hasAnyStatus([
            CampaignStatus::DRAFT(),
            CampaignStatus::PAUSED(),
        ])) {
            return $this->can('create');
        }

        return false;
    }

    protected function canEdit(Model $record): bool
    {
        if (!$this->canRemove($record)) {
            return false;
        }

        return $this->can('edit', $record);
    }

    protected function canDetach(Model $record): bool
    {
        if (!$this->canRemove($record)) {
            return false;
        }

        return $this->can('detach', $record);
    }

    private function canRemove(Model $contact)
    {
        $campaignContact = $this->getPivotModel($contact);

        if (!$campaignContact->isPending()) {
            return false;
        }

        if ($this->ownerRecord->hasAnyStatus([
            CampaignStatus::FINISHED(),
            CampaignStatus::CANCELED(),
            CampaignStatus::ACTIVE(),
        ])) {
            return false;
        }

        return true;
    }

    private function getPivotModel(Model $contact)
    {
        return CampaignContact::whereContactId($contact->id)
            ->whereCampaignId($this->ownerRecord->id)
            ->first();
    }
}
