<?php

namespace Octo\Resources\Objects;

class Table
{
    private $columns = [];

    public function __construct()
    {
        $this->builder();

        return $this;
    }

    public function add($title, $name, $type = 'text', $options = [])
    {
        array_push($this->columns, (object)[
            'title' => $title,
            'name' => $name,
            'type' => $type,
            'options' => (object) $options
        ]);

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function builder()
    {

    }
}
