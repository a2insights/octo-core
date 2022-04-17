<?php

namespace Octo\System\Addons;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
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
    * Path to the composer.json addon.
    *
    * @var string
    */
    protected string $composerJsonPath;

    /**
     * AddonManager constructor.
     *
     * @param string $composerJsonPath
     */
    public function __construct($composerJsonPath = null)
    {
        $this->composerJsonPath = $composerJsonPath  ?? storage_path('app/addons');

        $this->ensureComposerJsonExists();
    }

    /**
     * Install an addon.
     *
     * @param AddonContract $addon
     * @return void
     */
    public function install(AddonContract $addon)
    {
        $addon = $this->getAddon($addon);

        if ($addon->isInstalled()) {
            return;
        }

        $this->pushAddonToComposer($addon);

        $addon->install();
    }

    /**
     * Uninstall an addon.
     *
     * @return void
     */
    public function uninstall($addon)
    {
        $addon = $this->getAddon($addon);

        if (! $addon->isInstalled()) {
            return;
        }

        $addon->uninstall();
    }

    /**
     * Get an addon.
     *
     * @return AddonContract
     */
    public function getAddon(AddonContract $addon): AddonContract
    {
        return $addon;
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

    /**
     * Push an addon to composer.json file.
     *
     * @return void
     */
    protected function pushAddonToComposer(AddonContract $addon)
    {
        Artisan::call('octo:addon-install', [
            'composer_command' => $this->buildAddomPusCommand($addon),
            'composer_json_path' => $this->composerJsonPath,
        ]);
    }

    /**
     * Build the addon push command.
     *
     * @param AddonContract $addon
     * @return array
     */
    private function buildAddomPusCommand(AddonContract $addon)
    {
        if ($addon->isVcs()) {
            return [
                'config',
                "repositories.{$addon->getRepositoryName()}",
                (new VcsAddon($addon->getName(), $addon->getRepositoryUrl()))->toJson(),
            ];
        }
    }

    /**
     * Ensure the composer.json file exists.
     *
     * @return void
     */
    private function ensureComposerJsonExists()
    {
        $filePath = "$this->composerJsonPath/composer.json";

        if (! file_exists($filePath)) {
            file_put_contents($filePath, '{}');
            Storage::disk('local')->put($filePath, '{}');
        }
    }
}
