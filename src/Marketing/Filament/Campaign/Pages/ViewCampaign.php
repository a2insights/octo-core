<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ViewRecord;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Filament\Campaign\CampaignResource;

class ViewCampaign extends ViewRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getActions(): array
    {
        return [
            ButtonAction::make('edit')
                ->disabled($this->record->hasAnyStatus([
                    CampaignStatus::ACTIVE(),
                    CampaignStatus::CANCELED(),
                    CampaignStatus::FINISHED(),
                ]))
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => $this->record])),
            ButtonAction::make('cancel')
                ->visible($this->record->isActive() && $this->record->isPaused())
                ->color('danger')
                ->action('cancel')
                ->requiresConfirmation()
                ->outlined()
                ->icon('heroicon-o-ban'),
             ButtonAction::make('finished')
                ->color('primary')
                ->visible($this->record->isFinished())
                ->disabled()
                ->outlined()
                ->icon('heroicon-o-check'),
            ButtonAction::make('start')
                ->color('success')
                ->visible($this->record->isDraft())
                ->requiresConfirmation()
                ->action('start')
                ->outlined()
                ->icon('heroicon-o-play'),
            ButtonAction::make('canceled')
                ->color('danger')
                ->visible($this->record->isCanceled())
                ->disabled()
                ->outlined()
                ->icon('heroicon-o-ban'),
            ButtonAction::make('resume')
                ->color('success')
                ->visible($this->record->isPaused())
                ->action('resume')
                ->outlined()
                ->icon('heroicon-o-play'),
            ButtonAction::make('pause')
                ->color('primary')
                ->visible($this->record->isActive())
                ->action('pause')
                ->outlined()
                ->icon('heroicon-o-pause')
        ];
    }

    public function start()
    {
        $this->record->start();

        $this->notify('success', 'Campaign started successfully', isAfterRedirect: true);

        return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
    }

    public function pause(): void
    {
        $this->record->pause();

        $this->notify('primary', 'Campaign paused successfully');
    }

    public function resume(): void
    {
        $this->record->resume();

        $this->notify('primary', 'Campaign resumed successfully');
    }

    public function cancel()
    {
        $this->record->cancel();

        $this->notify('danger', 'Campaign canceled successfully', isAfterRedirect: true);

        return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
    }
}
