<?php

namespace A2insights\FilamentSaas\User\Filament\Pages;

use A2insights\FilamentSaas\User\Filament\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
