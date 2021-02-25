<?php

namespace Octo\Resources\Components\Traits;

trait Icon
{
    public function svg(string $name)
    {
        return svg($name);
    }
}
