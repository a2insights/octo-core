<?php

namespace Octo\Resources\Components\quasar;

class OActionQuasar
{
    private $name;

    private $disabled = false;

    protected $route;

    private $icon;

    private $variant;

    protected $tooltip = '';

    protected $value;

    protected $show = true;

    public function __construct(
        $route,
        $icon = '',
        $variant = 'primary'
    )
    {
        $this->name = $route->name;
        $this->route = $route;
        $this->variant = $variant;
        $this->icon = $icon;
        $this->tooltip = "$this->name";
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function setShow($show)
    {
        $this->show = $show;

        return $this;
    }

    public function get()
    {
        return $this->transform();
    }

    public function route()
    {
        return $this->route;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIcon()
    {
        if (str_contains($this->route->name, 'edit')){
            $this->icon = 'edit';
        }

        if (str_contains($this->route->name, 'destroy')){
            $this->icon = 'delete_forever';
        }

        if (str_contains($this->route->name, 'show')){
            $this->icon = 'remove_red_eye';
        }

        if (str_contains($this->route->name, 'download')){
            $this->icon = 'cloud_download';
        }

        return $this->icon;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTooltip()
    {
        return $this->tooltip;
    }

    public function getVariant()
    {
        return $this->variant;
    }

    public function getShow()
    {
        return $this->show;
    }

    protected function transform()
    {
        return [
            'name' => $this->getName(),
            'action' => $this->name,
            'tooltip' => $this->getTooltip(),
            'route' => $this->route(),
            'variant' => $this->getVariant(),
            'icon' => $this->getIcon(),
            'show' => $this->getShow(),
            'disabled' => $this->disabled,
            'value' => $this->getValue(),
        ];
    }
}
