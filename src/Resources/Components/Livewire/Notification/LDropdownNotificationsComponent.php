<?php

namespace Octo\Resources\Components\Livewire\Notification;

use Livewire\Component;
use Octo\Resources\Components\Livewire\Mixins\LNotificationMixin;

class LDropdownNotificationsComponent extends Component
{
    use LNotificationMixin;

    /**
     * Listeners
     *
     * @var string[]
     */
    protected $listeners = ['refreshNotifications' => '$refresh'];

    /**
     * Render the view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('octo::livewire.dropdown-notifications', [
            'notifications' => $this->getNotifications(4),
            'noReads' => $this->getUser()->unreadNotifications->count()
        ]);
    }
}