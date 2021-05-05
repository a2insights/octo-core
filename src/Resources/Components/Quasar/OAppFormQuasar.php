<?php

namespace Octo\Resources\Components\Quasar;

interface OAppFormQuasar
{
    public function repository();
    public function onSubmit();
    public function fields($model);
    public function actions($model);
}
