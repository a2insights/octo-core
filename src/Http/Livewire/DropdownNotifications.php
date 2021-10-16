<?php

namespace Octo\Http\Livewire;

use Livewire\Component;
use Octo\Resources\Components\Traits\NotificationComponent;

class DropdownNotifications extends Component
{
    use NotificationComponent;

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function render()
    {
        return view('octo::livewire.dropdown-notifications', [
            'notifications' => $this->getNotifications(4),
            'noReads' => $this->getUser()->unreadNotifications->count()
        ]);
    }
}
