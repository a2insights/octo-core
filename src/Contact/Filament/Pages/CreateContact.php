<?php

namespace Octo\Contact\Filament\Pages;

use Filament\Resources\Pages\CreateRecord;
use Octo\Contact\Filament\ContactResource;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
