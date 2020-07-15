<?php

namespace Octo\Resources\Components;

use Illuminate\View\Component;
use Octo\Resources\Objects\Column;
use ReflectionClass;

class TableComponent extends Component
{
    public $table;

    public $types;

    public function __construct($table)
    {
        $this->table = $table;
        $this->types = (new ReflectionClass(Column::class))->getConstants();
    }

    public function render()
    {
        return view('octo::components.table');
    }

    public function actionTypes($types)
    {
        return explode('|', $types);
    }
}
