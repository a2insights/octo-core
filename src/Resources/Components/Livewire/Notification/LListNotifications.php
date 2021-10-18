<?php

namespace Octo\Resources\Components\Livewire\Notification;

use Livewire\Component;
use Octo\Resources\Components\Livewire\Mixins\LNotificationMixin;

class LListNotifications extends Component
{
    use LNotificationMixin;

    /**
     * Filter value of notifications list
     *
     * @var string
     */
    public $filter = 'all';

    /**
     * Return the view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('octo::livewire.list-notifications', [
            'notifications' => $this->getNotifications()
        ]);
    }

    /**
     * Do filter
     *
     * @param $filter
     */
    public function filter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Mark notification as unread
     *
     * @param $id
     */
    public function markAsUnread($id)
    {
        $this->getNotification($id)->markAsUnRead();
        $this->emit('refreshNotifications');
    }

    /**
     * Mark notification as read
     *
     * @param $id
     */
    public function markAsRead($id)
    {
        $this->getNotification($id)->markAsRead();
        $this->emit('refreshNotifications');
    }
}
