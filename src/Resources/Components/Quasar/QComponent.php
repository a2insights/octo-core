<?php

namespace Octo\Resources\Components\Quasar;

abstract class QComponent implements QComponentContract
{
    /**
     * Get props of resource.
     *
     * @return mixed
     */
    public abstract function getProps();
}
