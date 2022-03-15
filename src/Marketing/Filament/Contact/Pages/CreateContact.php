<?php

namespace Octo\Marketing\Filament\Contact\Pages;

use Filament\Resources\Pages\CreateRecord;
use Octo\Marketing\Filament\Contact\ContactResource;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
