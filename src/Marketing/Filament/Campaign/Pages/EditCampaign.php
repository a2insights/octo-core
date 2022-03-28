<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Resources\Pages\EditRecord;
use Octo\Marketing\Filament\Campaign\CampaignResource;
use Octo\Marketing\Models\Campaign;

class EditCampaign extends EditRecord
{
    protected static string $resource = CampaignResource::class;

    public function beforeFill()
    {
        if (!$this->record->isDraft() && !$this->record->isPaused()) {
            return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['properties']['channels'] = [Campaign::$MAIL_CHANNEL];

        return $data;
    }
}
