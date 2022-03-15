<?php

namespace Octo\Marketing\Filament\Contact\Pages;

use Filament\Resources\Pages\ListRecords;
use Octo\Marketing\Filament\Contact\ContactResource;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;
}
