<?php

namespace Octo\Resources;

class NotificationRouteObject implements NotificationRouteObjectContract
{
    private $name;
    private $params;
    private $query;
    private $url;

    public function __construct(string $name, array $params = [], array $query = [])
    {
        $this->name = $name;
        $this->params = $params;
        $this->query = $query;
        $this->url = route($name) . '/' . http_build_query($this->query);

    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'params' => $this->params,
            'query' => $this->query,
            'url' => $this->url
        ];
    }
}
