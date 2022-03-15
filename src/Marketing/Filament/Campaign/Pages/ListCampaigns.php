<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Resources\Pages\ListRecords;
use Octo\Marketing\Filament\Campaign\CampaignResource;

class ListCampaigns extends ListRecords
{
    protected static string $resource = CampaignResource::class;
}
