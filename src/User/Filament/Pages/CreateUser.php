<?php

namespace Octo\User\Filament\Pages;

use Filament\Resources\Pages\CreateRecord;
use Octo\User\Filament\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
