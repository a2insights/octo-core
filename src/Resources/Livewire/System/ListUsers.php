<?php

namespace Octo\Resources\Livewire\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ListUsers extends DataTableComponent
{
    public bool $viewingModal = false;

    public $user;

    public $userCurrentPlan;

    public function getTableRowUrl(): string
    {
        return '#';
    }

    public function setTableRowAttributes($row): array
    {
        return ['wire:click.prevent' => 'viewModal('.$row->id.')'];
    }

    public function viewModal($id): void
    {
        $this->user = User::findOrFail($id);

        $this->viewingModal = true;
        $this->userCurrentPlan = $this->getUserCurrentPlan($this->user);
    }

    public function resetModal(): void
    {
        $this->reset('viewingModal', 'user');
    }

    public function filters(): array
    {
        return [
            'filters' => Filter::make(__('octo::messages.system.users.filters'))
                ->select([
                    '' => __('octo::messages.system.users.all'),
                    'verified' => __('octo::messages.system.users.verified'),
                    'unverified' => __('octo::messages.system.users.unverified'),
                ]),
        ];
    }

    public function modalsView(): string
    {
        return 'octo::livewire.system.users.modals';
    }

    public function columns(): array
    {
        return [
            Column::make(__('octo::messages.system.users.id'), 'id')->sortable(),
            Column::make(__('octo::messages.system.users.name'), 'name'),
            Column::make(__('octo::messages.system.users.email'), 'email'),
            Column::make(__('octo::messages.system.users.phone'), 'phone_number'),
            Column::make(__('octo::messages.system.users.created_at'), 'created_at')->sortable()->format(fn ($v) => $v?->diffForHumans()),
            Column::make(__('octo::messages.system.users.verified_at'), 'email_verified_at')->sortable()->format(fn ($v) => $v?->diffForHumans()),
        ];
    }

    public function query(): Builder
    {
        return User::query()
            ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term))
            ->when($this->getFilter('filters'), fn ($query, $verified) => $verified === 'verified' ? $query->whereNotNull('email_verified_at') : $query->whereNull('email_verified_at'))
            ->orderBy('created_at', 'desc');
    }


    private function getUserCurrentPlan($user)
    {
        return $user->subscription('main') ? [
            'name' => $user->subscription('main')->getPlan()->getName(),
            'price' => $user->subscription('main')->getPlan()->getPrice(),
        ] : null;
    }
}
