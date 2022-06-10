<?php

namespace Octo\System\Http\Livewire;

use LaravelViews\Views\GridView;
use Octo\System\Models\Theme;

class ListThemes extends GridView
{
    protected $model = Theme::class;

    public $withBackground = true;

    public $maxCols = 3;

    public $searchBy = ['name', 'title', 'description'];

    public function card($model)
    {
        return [
            'image' => $model->thumbnail,
            'title' => $model->title,
            'subtitle' => $model->version,
            'description' => $model->description
        ];
    }

    protected function actionsByRow()
    {
        return [
            new ThemeInstallAction(),
            new ThemeUninstallAction(),
        ];
    }
}
