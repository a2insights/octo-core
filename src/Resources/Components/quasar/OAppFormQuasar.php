<?php

namespace Octo\Resources\Components\quasar;

interface OAppFormQuasar
{
    public function repository();
    public function onSubmit();
    public function fields($model);
    public function actions($model);
}
