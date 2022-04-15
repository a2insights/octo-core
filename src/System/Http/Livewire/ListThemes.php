<?php

namespace Octo\System\Http\Livewire;

use LaravelViews\Views\GridView;
use Octo\System\Models\Theme;

class ListThemes extends GridView
{
    protected $model = Theme::class;

    public $withBackground = true;

    public $maxCols = 4;

    public $searchBy = ['name', 'description'];

    public function card($model)
    {
        return [
            'image' => 'https://via.placeholder.com/150',
            'title' => $model->name,
            'subtitle' => $model->version,
            'description' => $model->description
        ];
    }

    protected function actionsByRow()
    {
        return [
            new ThemeInstallAction,
        ];
    }
}
