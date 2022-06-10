<?php

namespace Octo\System\Addons;

use Illuminate\Support\Facades\Artisan;
use Octo\System\Addons\Contracts\AddonContract;
use Octo\System\Addons\Types\VcsAddon;

class AddonManager
{
    /**
     * Addons themes.
     *
     * @var array
     */
    protected $themes = [];

    /**
     * Addons plugins.
     *
     * @var array
     */
    protected $plugins = [];

    /**
     * Install an addon.
     *
     * @param AddonContract $addon
     * @return void
     */
    public function install(AddonContract $addon)
    {
        if ($addon->isInstalled()) {
            return;
        }

        $addonType = $this->resolveAddonType($addon);

        try {
            Artisan::call("octo:composer", [
                'instructions' => $addonType->add()
            ]);

            Artisan::call("octo:composer", [
                'instructions' => "require|{$addon->getName()}:{$addon->getVersion()}"
            ]);

            $addon->markAsInstalled();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Uninstall an addon.
     *
     * @param AddonContract $addon
     * @return void
     */
    public function uninstall(AddonContract $addon)
    {
        if (! $addon->isInstalled()) {
            return;
        }

        try {
            Artisan::call("octo:composer", [
                'instructions' => "remove|{$addon->getName()}:{$addon->getVersion()}"
            ]);

            $addon->markAsUninstalled();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get theme addons.
     *
     * @return array
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Get plugins addons.
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    private function resolveAddonType(AddonContract $addon)
    {
        if ($addon->isVcs()) {
            return new VcsAddon($addon->getName(), $addon->getRepositoryUrl());
        }
    }
}
