<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Octo\Marketing\Filament\Campaign\CampaignResource;
use Octo\Marketing\Models\Campaign;

class CreateCampaign extends CreateRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['properties']['channels'] = [Campaign::$MAIL_CHANNEL];

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::forceCreate($data);
    }
}
