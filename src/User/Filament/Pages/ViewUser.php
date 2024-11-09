<?php

namespace A2Insights\FilamentSaas\User\Filament\Pages;

use A2Insights\FilamentSaas\User\Filament\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

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
