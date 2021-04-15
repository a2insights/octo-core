<?php

namespace Octo\Resources;

class OAppFormResource implements OComponentResource
{
    protected $name;
    protected $form;
    protected $model;

    public function __construct($form)
    {
        $this->form = new $form() ;
    }

    public function getProps()
    {
        return [
            'name' => '',
            'fields' => [

            ],
        ];
    }
}


