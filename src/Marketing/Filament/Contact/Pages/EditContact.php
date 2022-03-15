<?php

namespace Octo\Marketing\Filament\Contact\Pages;

use Filament\Resources\Pages\EditRecord;
use Octo\Marketing\Filament\Contact\ContactResource;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;
}
