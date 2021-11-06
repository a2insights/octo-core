<?php

namespace Octo\Resources\Livewire\Notification;

use Livewire\Component;
use Octo\Resources\Livewire\Concerns\Notification;

class DropdownNotifications extends Component
{
    use Notification;

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

    /**
     * Listeners
     *
     * @return string[]
     */
    public function getListeners()
    {
        return [
            'refreshNotifications' => '$refresh',
            "echo-private:user-notification.{$this->getUser()->id},.Octo\\Events\\NewPusherNotification" => '$refresh'
        ];
    }
}
