<?php

namespace Octo\Contact\Filament\Pages;

use Filament\Resources\Pages\EditRecord;
use Octo\Contact\Filament\ContactResource;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;
}
