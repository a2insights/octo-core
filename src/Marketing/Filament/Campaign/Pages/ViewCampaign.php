<?php

namespace Octo\Marketing\Filament\Campaign\Pages;

use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Notification;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Filament\Campaign\CampaignResource;
use Octo\Marketing\Notifications\CampaignNotification;

class ViewCampaign extends ViewRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getActions(): array
    {
        return CampaignStatus::FINISHED() !== $this->record->status ? [
            ButtonAction::make('edit')
                ->disabled(CampaignStatus::ACTIVE() === $this->record->status)
                ->visible(CampaignStatus::CANCELLED() !== $this->record->status)
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => $this->record])),
            ButtonAction::make('cancel')
                ->hidden(CampaignStatus::ACTIVE() === $this->record->status)
                ->visible(CampaignStatus::CANCELLED() !== $this->record->status)
                ->color('danger')
                ->action('cancel')
                ->requiresConfirmation()
                ->outlined()
                ->icon('heroicon-o-ban'),
            $this->action()
        ] : [
            ButtonAction::make('finished')
            ->color('primary')
            ->disabled()
            ->outlined()
            ->icon('heroicon-o-check'),
        ];
    }

    public function start()
    {
        $this->record->status = CampaignStatus::ACTIVE();
        $this->record->start_at = now();

        Notification::send($this->record->contacts, new CampaignNotification($this->record));

        $this->record->save();

        $this->notify('success', 'Campaign started successfully', isAfterRedirect: true);

        return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
    }

    public function pause(): void
    {
        $this->record->status = CampaignStatus::PAUSED();
        $this->record->save();

        $this->notify('primary', 'Campaign paused successfully');
    }

    public function cancel()
    {
        $this->record->status = CampaignStatus::CANCELLED();

        $this->record->save();

        $this->notify('danger', 'Campaign canceled successfully', isAfterRedirect: true);

        return redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
    }

    private function action()
    {
        if ($this->record->status == CampaignStatus::ACTIVE()) {
            return ButtonAction::make('pause')
                ->color('primary')
                ->action('pause')
                ->outlined()
                ->icon('heroicon-o-pause');
        }

        if ($this->record->status == CampaignStatus::PAUSED()) {
            return ButtonAction::make('resume')
                ->color('success')
                ->action('start')
                ->outlined()
                ->icon('heroicon-o-play');
        }

        if ($this->record->status == CampaignStatus::CANCELLED()) {
            return ButtonAction::make('canceled')
                ->color('danger')
                ->disabled()
                ->outlined()
                ->icon('heroicon-o-ban');
        }

        return ButtonAction::make('start')
            ->color('success')
            ->requiresConfirmation()
            ->action('start')
            ->outlined()
            ->icon('heroicon-o-play');
    }
}
