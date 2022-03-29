<?php

namespace Octo\Marketing\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Octo\Marketing\Stats\ContactStats;

class ContactsChart extends LineChartWidget
{
    protected static ?string $heading = 'Total contacts';

    protected function getData(): array
    {
        $stats = ContactStats::query()
            ->start(now()->subMonths(11))
            ->end(now()->subSecond())
            ->groupByMonth()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Contacts',
                    'data' => $stats->pluck('value')->toArray(),
                ],
            ],
            'labels' => $stats->pluck('start')->map(fn ($date) => $date->format('M'))->toArray(),
        ];
    }
}
