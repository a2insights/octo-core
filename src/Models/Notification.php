<?php

namespace Octo\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification {

    public function scopeSearch($query, $term)
    {
        return $query->where('data', 'like', '%'.$term.'%');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }
}
