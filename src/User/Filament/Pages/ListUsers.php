<?php

namespace A2insights\FilamentSaas\User\Filament\Pages;

use A2insights\FilamentSaas\User\Filament\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
