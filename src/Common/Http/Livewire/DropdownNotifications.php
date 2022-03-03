<?php

namespace Octo\Common\Http\Livewire;

use Livewire\Component;
use Octo\Common\Concerns\Notifications;

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
        return view('octo::components.dropdown-notifications', [
            'notifications' => $this->getNotifications(4),
            'noReads' => $this->getUser()->unreadNotifications->count()
        ]);
    }
}
