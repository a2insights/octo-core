<?php

namespace Octo\Http\Livewire;

use Livewire\Component;
use Octo\Resources\Components\Traits\NotificationComponent;

class ListNotifications extends Component
{
    use NotificationComponent;

    public $filter = 'all';

    public function render()
    {
        return view('octo::livewire.list-notifications', [
            'notifications' => $this->getNotifications()
        ]);
    }

    public function filter($filter)
    {
        $this->filter = $filter;
    }

    public function markAsUnread($id)
    {
        $this->getNotification($id)->markAsUnRead();
        $this->emit('refreshNotifications');
    }

    public function markAsRead($id)
    {
        $this->getNotification($id)->markAsRead();
        $this->emit('refreshNotifications');
    }
}
