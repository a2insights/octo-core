<?php

namespace Octo\Resources\Components\Quasar;

interface OAppTableQuasar
{
    public function repository();
    public function headers();
    public function row($model);
    public function actions($model);
}
