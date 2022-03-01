<?php

namespace Octo\Common\Filament\Pages;

use Filament\Resources\Pages\CreateRecord;
use Octo\Common\Filament\ContactResource;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
