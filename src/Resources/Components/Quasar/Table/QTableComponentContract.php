<?php

namespace Octo\Resources\Components\Quasar\Table;

interface QTableComponentContract
{
    public function repository();
    public function headers();
    public function row($model);
    public function actions($model);
}
