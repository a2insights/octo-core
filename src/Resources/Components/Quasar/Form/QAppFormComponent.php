<?php

namespace Octo\Resources\Components\Quasar\Form;

use Octo\Resources\Components\Quasar\QComponent;

class QAppFormComponent implements QComponent
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


