<?php

namespace Octo\Resources\Components\Mixins;

trait Icon
{
    /**
     * Return a svg icon from BladeUI.
     *
     * @param string $name
     * @return \BladeUI\Icons\Svg;
     */
    public function svg(string $name)
    {
        return svg($name);
    }
}
