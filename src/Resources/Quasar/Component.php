<?php

namespace Octo\Resources\Quasar;

abstract class Component implements ComponentContract
{
    /**
     * Get props of resource.
     *
     * @return mixed
     */
    public abstract function getProps();
}
