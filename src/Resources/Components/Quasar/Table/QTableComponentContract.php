<?php

namespace Octo\Resources\Components\Quasar\Table;

interface QTableComponentContract
{
    public function model();
    public function headers();
    public function row($model);
    public function actions($model);
}
