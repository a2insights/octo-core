<?php

namespace Octo\Resources\Components\Traits;

use Illuminate\Support\Facades\Auth;

trait NotificationComponent
{
    private function getNotification($id)
    {
        return $this->getUser()->notifications()->find($id);
    }

    private function getNotifications(int $take = null)
    {
        return $this->getUser()
            ->notifications()
            ->when($take, fn($q) => $q->take($take))
            ->when(isset($this->filter) && $this->filter === 'unread', function ($q) {
                return $q->whereNull('read_at');
            })
            ->orderBy('id')
            ->get();
    }

    private function getUser()
    {
        return Auth::user();
    }

    public function markAsUnread($id)
    {
        $this->getNotification($id)->markAsRead();
    }

    public function markAsRead($id)
    {
        $this->getNotification($id)->markAsRead();
    }

    public function redirectTo($id)
    {
        $notification = $this->getNotification($id);

        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        if ($notification->data['route']) {
            return redirect(route($notification->data['route']['name'], $notification->data['route']['params']));
        }

        if (!$notification->data['route'] && !$notification->read_at) {
            $this->emit('refreshNotifications');
        }
    }
}
