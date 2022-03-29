<?php

namespace Octo\Marketing\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Octo\Marketing\Stats\CampaignStats;
use Octo\Marketing\Stats\ContactStats;

class Overview extends BaseWidget
{
    protected function getCards(): array
    {
        $statsCampaignsWeek = CampaignStats::query()
            ->start(now()->subMonths(1))
            ->end(now()->subSecond())
            ->groupByWeek()
            ->get();

        $statsContactsWeek = ContactStats::query()
            ->start(now()->subMonths(1))
            ->end(now()->subSecond())
            ->groupByWeek()
            ->get();

        return [
            Card::make('Contacts', $statsContactsWeek->last()->value)
                ->description($this->description($statsContactsWeek->last()))
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($statsContactsWeek->pluck('value')->toArray())
                ->color($this->color($statsContactsWeek->last())),
            Card::make('Campaigns', $statsCampaignsWeek->last()->value)
                ->description($this->description($statsCampaignsWeek->last()))
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($statsCampaignsWeek->pluck('value')->toArray())
                ->color($this->color($statsCampaignsWeek->last())),
        ];
    }

    private function color($stats)
    {
        if ($stats->increments - $stats->decrements === 0) {
            return 'primary';
        }

        if ($stats->increments > $stats->decrements) {
            return 'success';
        }

        return 'danger';
    }

    private function description($stats)
    {
        if ($stats->increments - $stats->decrements === 0) {
            return "No change";
        }

        if ($stats->increments > $stats->decrements) {
            return "+{$stats->increments} since last week";
        }

        return "-{$stats->decrements} since last week";
    }
}
