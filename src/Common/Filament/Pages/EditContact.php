<?php

namespace Octo\Common\Filament\Pages;

use Filament\Resources\Pages\EditRecord;
use Octo\Common\Filament\ContactResource;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;
}
