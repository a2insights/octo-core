<?php

namespace Octo\Resources\Components\quasar;

interface OAppTableQuasar
{
    public function repository();
    public function headers();
    public function row($model);
    public function actions($model);
}
