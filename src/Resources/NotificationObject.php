<?php

namespace Octo\Resources;

trait NotificationObject
{
    public function toArray($notifiable)
    {
        return [
            'route' => $this->getRoute()->toArray(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription()
        ];
    }
}
