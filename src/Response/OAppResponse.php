<?php

namespace Octo\Response;

use Illuminate\Contracts\Support\Responsable;

class OAppResponse implements Responsable
{
    protected $page;

    protected $components = [];

    public $redirect;

    public function addComponent($component)
    {
        array_push($this->components, $component->getProps());

        return $this;
    }

    public function __construct($page)
    {
        $this->page = $page;
    }

    protected function mapComponents($components)
    {
        $mapped = [];

        foreach ($components as $component){
            $mapped[$component['name']] = $component;
        }

        return $mapped;
    }

    public function toResponse($request)
    {
        $data = [
            'page' => $this->page,
            'components' => $this->mapComponents($this->components)
        ];

        if (isset($request->user)) {
            $data['auth'] =  [
                'user' => $request->user(),
                'token' => $request->bearerToken()
            ];
        }

        return $data;
    }
}
