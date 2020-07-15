<?php

namespace Octo\Resources\Builders;

class TableBuilder
{
    private $table;

    public function create($table, $collection)
    {
        $this->table['columns'] = app($table)->getColumns();
        $this->table['collection'] = $collection;

        return $this;
    }

    public function build()
    {
        return (object) $this->table;
    }
}
