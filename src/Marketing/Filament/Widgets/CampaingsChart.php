<?php

namespace Octo\Marketing\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Octo\Marketing\Stats\CampaignStats;

class CampaingsChart extends LineChartWidget
{
    protected static ?string $heading = 'Total campaigns';

    protected function getData(): array
    {
        $stats = CampaignStats::query()
            ->start(now()->subMonths(11))
            ->end(now()->subSecond())
            ->groupByMonth()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Campaigns',
                    'data' => $stats->pluck('value')->toArray(),
                ],
            ],
            'labels' => $stats->pluck('start')->map(fn ($date) => $date->format('M'))->toArray(),
        ];
    }
}
