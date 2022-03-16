<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Resources\Pages\EditRecord;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Filament\Campaign\CampaignResource;

class EditCampaign extends EditRecord
{
    protected static string $resource = CampaignResource::class;

    public function beforeFill()
    {
        if ($this->record->status !== CampaignStatus::DRAFT() && $this->record->status !== CampaignStatus::PAUSED()) {
            return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
