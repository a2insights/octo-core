<?php

namespace Octo\System\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Octo\Billing\Saas;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ListUsers extends DataTableComponent
{
    public bool $viewingModal = false;

    public $user;

    public $plans = [];

    public $plan;

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
        if_feature_is_enabled('billing', function () use ($id) {
            $this->user = User::findOrFail($id);

            $this->viewingModal = true;

            $this->plan = $this->getCurrentPlan($this->user);

            $this->plans = Saas::getPlans()
                ->filter(
                    fn ($p) => in_array(
                        $p->getId(),
                        $this->user->subscriptions
                            ->filter(fn ($s) => $s->stripe_price !== $this->plan['id'])
                            ->pluck('stripe_price')
                            ->toArray()
                    )
                )->toArray();
        });
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
        return 'octo::system.users.modals';
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


    private function getCurrentPlan($user)
    {
        $currentPlan = Saas::getPlan($user->current_subscription_id)->toArray();

        $subscription = $user->subscription($currentPlan['name']);

        $currentPlan['features'] = collect($currentPlan['features'])->map(fn ($f) => [
            'id' => $f['id'],
            'name' => $f['name'],
            'value' => $f['value'],
            'used' => $subscription?->getUsedQuota($f['id']),
            'total_used' => $subscription?->getTotalUsedQuota($f['id']),
        ]);

        return $user->subscription($currentPlan['name']) ? $currentPlan : null;
    }
}
