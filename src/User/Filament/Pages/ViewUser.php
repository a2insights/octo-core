<?php

namespace Octo\User\Filament\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Octo\User\Filament\UserResource;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return collect([
            Actions\DeleteAction::make()->disabled(fn () => $this->record->is(auth()->user()) || $this->record->hasRole('super_admin')),
        ])->when(
            auth()->user()->hasRole('super_admin') && ! $this->record->hasRole('super_admin'),
            fn ($actions) => $actions->push(\XliteDev\FilamentImpersonate\Pages\Actions\ImpersonateAction::make()->record($this->getRecord()))
        )->toArray();
    }
}
