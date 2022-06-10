<?php

namespace Octo\System\Http\Livewire;

use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;
use Octo\System\Addons\AddonManager;
use Octo\System\Addons\ThemeAddon;

class ThemeUninstallAction extends Action
{
    use Confirmable;

    public $title = "Uninstall theme";

    public $icon = "trash";

    public function getConfirmationMessage($model = null)
    {
        return "Do you really want to uninstall {$model->name} theme?";
    }

    public function handle($model, View $view)
    {
        $manager = new AddonManager();

        $manager->uninstall((new ThemeAddon($model)));

        $this->success("Theme {$model->name} uninstalled successfully!");
    }

    public function renderIf($item, View $view)
    {
        return $item->installed;
    }
}
