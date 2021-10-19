<?php

namespace Octo\Resources\Components\Quasar\Form;

interface FormContract
{
    public function model();
    public function onSubmit();
    public function fields($model);
    public function actions($model);
}
