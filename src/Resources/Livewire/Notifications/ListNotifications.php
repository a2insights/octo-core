<?php

namespace Octo\Resources\Livewire\Notifications;

use Octo\Resources\Livewire\Concerns\Notifications;
use Illuminate\Database\Eloquent\Builder;
use Octo\Models\Notification;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;


class ListNotifications extends DataTableComponent
{
    use Notifications;

    public function filters(): array
    {
        return [
            'unreads' => Filter::make(__('octo::messages.notifications.status'))
                ->select([
                    '' => __('octo::messages.notifications.all'),
                    1 =>  __('octo::messages.notifications.reads'),
                    0 => __('octo::messages.notifications.unreads'),
                ])
        ];
    }

    public function getTableRowUrl($row): string
    {
        return route($row['data']['route']['name'], $row['data']['route']['params']);
    }

    public function rowView(): string
    {
        return 'octo::livewire.notifications.row-notification';
    }

    public function columns(): array
    {
        return [
            Column::make(__('octo::messages.notifications.title'), 'data.title'),
            Column::make(__('octo::messages.notifications.description'), 'data.description'),
            Column::make(__('octo::messages.notifications.created_at'), 'created_at')->sortable(),
            Column::make(__('octo::messages.notifications.actions'))->addClass('flex justify-end')
        ];
    }

    public function query(): Builder
    {
        return Notification::query()
            ->where('notifiable_type', $this->getUser()::class)
            ->where('notifiable_id', $this->getUser()->id)
            ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term))
            ->when($this->getFilter('unreads'), fn ($query, $verified) => $verified === 'verified' ? $query->whereNotNull('read_at') : $query->whereNull('read_at'))
            ->orderBy('created_at', 'desc');
    }
}
