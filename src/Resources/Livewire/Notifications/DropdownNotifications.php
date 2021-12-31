<?php

namespace Octo\Resources\Livewire\Notifications;

use Livewire\Component;
use Octo\Resources\Livewire\Concerns\Notifications;

class DropdownNotifications extends Component
{
    use Notifications;

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
