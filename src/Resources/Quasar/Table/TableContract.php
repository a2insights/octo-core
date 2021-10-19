<?php

namespace Octo\Resources\Quasar\Table;

interface TableContract
{
    public function model();
    public function headers();
    public function row($model);
    public function actions($model);
}
