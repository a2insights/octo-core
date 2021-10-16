<?php

namespace Octo\Resources;

interface NotificationObjectContract
{
    public function getTitle(): string;
    public function getDescription(): string;
    public function getRoute(): NotificationRouteObject;
}
