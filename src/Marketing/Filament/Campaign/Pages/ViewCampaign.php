<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ViewRecord;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Filament\Campaign\CampaignResource;

class ViewCampaign extends ViewRecord
{
    protected static string $resource = CampaignResource::class;

    protected static string $view = 'octo::marketing.campaign';

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
                ->visible($this->record->isPaused())
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
                ->visible($this->record->isDraft() && $this->record->contacts->count() > 0)
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

        return $this->back('Campaign started successfully', 'success');
    }

    public function pause()
    {
        $this->record->pause();

        return $this->back('Campaign paused successfully', 'primary');
    }

    public function resume()
    {
        $this->record->resume();

        return $this->back('Campaign resumed successfully', 'success');
    }

    public function cancel()
    {
        $this->record->cancel();

        return $this->back('Campaign canceled successfully', 'danger');
    }

    private function back($msg, $variant)
    {
        $this->notify($variant, $msg, isAfterRedirect: true);

        return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
    }
}
