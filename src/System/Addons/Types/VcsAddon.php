<?php

namespace Octo\System\Addons\Types;

class VcsAddon
{
    /**
     * Addon name.
     *
     * @param string
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
     * Get addon array representation.
     *
     * @return array
     */
    public function add(): string
    {
        return "config|repositories.{$this->name}|vcs|{$this->url}";
    }
}
