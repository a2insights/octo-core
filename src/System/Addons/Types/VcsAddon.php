<?php

namespace Octo\System\Addons\Types;

class VcsAddon
{
    /**
     * Addon name.
     *
     * @param Theme $theme
     */
    protected $name;

    /**
     * Addon type.
     *
     * @param string
     */
    protected $type = 'vcs';

    /**
     * Addon repository url.
     *
     * @param string
     */
    protected $url;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Get addon string representation.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode([
            'type' => $this->type,
            'url' => $this->url,
        ]);
    }
}
