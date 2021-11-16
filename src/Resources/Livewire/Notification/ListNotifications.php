<?php

namespace Octo\Resources\Livewire\Notification;

use Livewire\Component;
use Octo\Resources\Livewire\Concerns\Notification;

class ListNotifications extends Component
{
    use Notification;

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
    }

    /**
     * Mark notification as read
     *
     * @param $id
     */
    public function markAsRead($id)
    {
        $this->getNotification($id)->markAsRead();
    }

    /**
     * Listeners
     *
     * @return string[]
     */
    public function getListeners()
    {
        return [
            "echo-private:user-notification.{$this->getUser()->id},.Octo\\Events\\NewPusherNotification" => '$refresh'
        ];
    }
}
