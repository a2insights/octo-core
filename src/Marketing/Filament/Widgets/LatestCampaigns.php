<?php

namespace Octo\Marketing\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Octo\Marketing\Models\Campaign;

class LatestCampaigns extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Campaign::latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                    ->label('ID')
                    ->sortable('desc'),
            TextColumn::make('name')
                ->searchable(),
        ];
    }
}
