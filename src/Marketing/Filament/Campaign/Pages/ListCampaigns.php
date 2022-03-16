<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Closure;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Octo\Marketing\Filament\Campaign\CampaignResource;

class ListCampaigns extends ListRecords
{
    protected static string $resource = CampaignResource::class;

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return function (Model $record): ?string {
            return static::getResource()::getUrl('view', ['record' => $record]);
        };
    }
}
