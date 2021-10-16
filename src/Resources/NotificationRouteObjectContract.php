<?php

namespace Octo\Resources;

interface NotificationRouteObjectContract
{
    public function __construct(string $name, array $params = []);
}
