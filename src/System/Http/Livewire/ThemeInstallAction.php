<?php

namespace Octo\System\Http\Livewire;

use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;
use Octo\System\Addons\AddonManager;
use Octo\System\Addons\ThemeAddon;

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
        $manager = new AddonManager();

        $manager->install((new ThemeAddon($model)));

        $this->success("Theme {$model->name} installed successfully!");
    }

    public function renderIf($item, View $view)
    {
        return !$item->installed;
    }
}
