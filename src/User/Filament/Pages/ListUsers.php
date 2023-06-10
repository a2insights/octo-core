<?php

namespace Octo\User\Filament\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Octo\User\Filament\UserResource;

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
