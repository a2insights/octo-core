<?php

namespace A2Insights\FilamentSaas\User\Filament\Widgets;

use A2Insights\FilamentSaas\User\Stats\UserStats;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UsersOverview extends BaseWidget
{
    use HasWidgetShield;

    protected function getCards(): array
    {
        $statsUsersWeek = UserStats::query()
            ->start(now()->subMonths(1))
            ->end(now()->subSecond())
            ->groupByWeek()
            ->get();

        return [
            Card::make('Users', $statsUsersWeek->last()->value)
                ->description($this->description($statsUsersWeek->last()))
                ->descriptionIcon('iconpark-trendtwo')
                ->chart($statsUsersWeek->pluck('value')->toArray())
                ->color($this->color($statsUsersWeek->last())),
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
            return 'No change';
        }

        if ($stats->increments > $stats->decrements) {
            return "+{$stats->increments} since last week";
        }

        return "-{$stats->decrements} since last week";
    }
}
