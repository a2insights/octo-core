<?php

namespace Octo\Resources\Livewire\Concerns;

use Illuminate\Support\Facades\Auth;

trait Notification
{
    /**
     * Get notification by id of auth user
     *
     * @param $id
     * @return mixed
     */
    private function getNotification($id)
    {
        return $this->getUser()->notifications()->find($id);
    }

    /**
     * Get all notifications of auth user
     *
     * @param int|null $take
     * @return mixed
     */
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

    /**
     * Get the auth user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private function getUser()
    {
        return Auth::user();
    }

    /**
     * Mark the notification as a unread
     *
     * @param $id
     */
    public function markAsUnread($id)
    {
        $this->getNotification($id)->markAsRead();
    }

    /**
     * Mark the notification as a unread
     *
     * @param $id
     */
    public function markAsRead($id)
    {
        $this->getNotification($id)->markAsRead();
    }

    /**
     * Redirect after notification click
     *
     * @param $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|void
     */
    public function redirectTo($id)
    {
        $notification = $this->getNotification($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        if ($notification->data['route']) {
            return redirect(route($notification->data['route']['name'], $notification->data['route']['params']));
        }

        if (!$notification->data['route'] && !$notification->read_at) {
            $this->emit('refreshNotifications');
        }
    }
}
