<?php

namespace Octo\Contact\Filament\Pages;

use Filament\Resources\Pages\ListRecords;
use Octo\Contact\Filament\ContactResource;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;
}
