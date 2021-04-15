<?php

namespace Octo\Resources;

use Illuminate\Support\Str;

class OAppTableResource implements OComponentResource
{
    protected $name;
    protected $filters;
    protected $rowsPerPageLabel = '';
    protected $rowsPerPageOptions = [5, 10, 20, 25];
    protected $data;
    protected $columns;
    protected $rows;
    protected $pagination;
    private $route;
    private $table;
    private $actions;
    private $repository;

    public function __construct($table)
    {
        $this->table = new $table() ;
        $this->route = $this->table->route();
        $this->name = $this->table->name ?? Str::random(10);
        $this->repository = $this->table->repository();
        $this->columns = $this->table->headers();
    }

    public function getProps()
    {
        $page = request('page') ?? 1;
        $rowsPerPage = request('rowsPerPage') ?? 10;
        $paginator = $this->repository->paginate($rowsPerPage, ['*'], 'page', $page);

        return [
            'name' => $this->name,
            'grid' => false,
            'route' => $this->route,
            'apiInteract' => (bool)$this->route,
            'data' => collect($paginator->items())->map(function ($model, $index){
                $newItem = $this->table->row($model);
                if ($index === 0){
                   $headers = $this->columns;
                   foreach ($headers as $key => $header){
                       $this->columns[$key] = [
                           'name' => array_keys($newItem)[$key],
                           'field' => array_keys($newItem)[$key],
                           'label' =>  $this->columns[$key],
                           'align' => 'left',
                       ];
                   }
                }
                $newItem['actions'] = $this->actions = $this->table->actions($model);
                return $newItem;
            }),
            'columns' => collect($this->columns)->add($this->actions ? [
                'name' => 'actions',
                'field' => 'actions',
                'label' =>  '',
                'align' => 'right',
            ] : null)->filter(function ($column) { return $column != null; }),
            'rowsPerPageOptions' => $this->rowsPerPageOptions,
            'rowsPerPageLabel' => $this->rowsPerPageLabel,
            'pagination' => [
                'sortBy' => null,
                'descending' => null,
                'page' => $paginator->currentPage(),
                'pages' => $paginator->lastPage(),
                'rowsPerPage' => (int)$paginator->perPage(),
                'rowsNumber' => $paginator->total()
            ]
        ];
    }
}


