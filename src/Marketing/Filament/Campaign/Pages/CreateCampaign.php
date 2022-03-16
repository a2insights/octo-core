<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Resources\Pages\CreateRecord;
use Octo\Marketing\Filament\Campaign\CampaignResource;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
