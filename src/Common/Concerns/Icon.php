<?php

namespace Octo\Common\Concerns;

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
