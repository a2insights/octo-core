<?php

namespace Octo\System\Addons;

use Octo\System\Addons\Contracts\AddonContract;
use Octo\System\Models\Theme;

class ThemeAddon implements AddonContract
{
    /**
     * Theme instance.
     *
     * @var Theme
     */
    protected $theme;

    /**
     * ThemeAddon constructor.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the addon name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->theme->name;
    }

    /**
     * Get the addon version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->theme->version;
    }

    /**
     * Get the repository url of the addon
     *
     * @return string
     */
    public function getRepositoryUrl(): string
    {
        return $this->theme->repository_url;
    }

    /**
     * Install the addon.
     *
     * @return void
     */
    public function markAsInstalled(): void
    {
        $this->theme->installed = true;
        $this->theme->save();
    }

    /**
     * Uninstall the addon.
     *
     * @return void
     */
    public function markAsUninstalled(): void
    {
        $this->theme->active = false;
        $this->theme->installed = false;
        $this->theme->save();
    }

    /**
     * Check if the addon is installed.
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return $this->theme->installed;
    }

    /**
     * Check if the addon is a VCS addon.
     *
     * @return bool
     */
    public function isVcs(): bool
    {
        return $this->theme->isVcs();
    }
}
