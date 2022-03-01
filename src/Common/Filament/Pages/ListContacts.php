<?php

namespace Octo\Common\Filament\Pages;

use Filament\Resources\Pages\ListRecords;
use Octo\Common\Filament\ContactResource;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;
}
