<?php

namespace Octo\User\Filament\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Octo\User\Filament\UserResource;
use Filament\Pages\Actions\Action;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->disabled(fn () => $this->record->is(auth()->user())),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament::resources/pages/edit-record.form.actions.save.label'))
            ->disabled(fn () => $this->record->is(auth()->user()))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }
}
