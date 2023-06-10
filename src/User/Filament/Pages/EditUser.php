<?php

namespace Octo\User\Filament\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Octo\User\Filament\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return collect([
            Actions\DeleteAction::make()->disabled(fn () => $this->record->is(auth()->user()) || $this->record->hasRole('super_admin')),
        ])->when(
            auth()->user()->hasRole('super_admin'),
            fn ($actions) => $actions->push(\XliteDev\FilamentImpersonate\Pages\Actions\ImpersonateAction::make()->record($this->getRecord()))
        )->toArray();
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament::resources/pages/edit-record.form.actions.save.label'))
            ->disabled(fn () => $this->record->is(auth()->user()) || $this->record->hasRole('super_admin'))
            ->submit('save')
            ->keyBindings(['ctrl+s']);
    }
}
