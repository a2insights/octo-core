<?php

namespace Octo\Resources\Components\Quasar\Form;

use Octo\Resources\Components\Quasar\Component;

class Form extends Component
{
    protected $name;
    protected $form;
    protected $model;

    public function __construct($form)
    {
        $this->form = new $form();
    }

    public function getProps()
    {
        return [
            'name' => '',
            'fields' => []
        ];
    }
}


