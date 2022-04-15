<?php

namespace Octo\System\Http\Livewire;

use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;

class ThemeInstallAction extends Action
{
    use Confirmable;

    public $title = "Install theme";

    public $icon = "download";

    public function getConfirmationMessage($model = null)
    {
        return "Do you really want to install {$model->name} theme?";
    }

    public function handle($model, View $view)
    {
        $this->success();
    }
}
