<?php

namespace Octo\Tests\Unit\Addons;

use Illuminate\Console\Application;
use Octo\System\Addons\AddonManager;
use Octo\System\Addons\ThemeAddon;
use Octo\System\Models\Theme;
use Octo\Tests\TestCase;

class AddonManagerTest extends TestCase
{
    private AddonManager $manager;

    public function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->loadMigrationsFrom(__DIR__ . '/../../../src/System/Database/migrations');

        Application::starting(function ($artisan) {
            $artisan->add(app(\Octo\Console\InstallAddonCommand::class));
        });

        $composerJsonPath = __DIR__;

        $this->manager = new AddonManager($composerJsonPath);
    }

    private function getThemeVcsAddon($name)
    {
        $theme = Theme::factory()->create([
            'name' => $name,
            'packagist_url' => null,
            'active' => false,
            'installed' => false,
        ]);

        return (new ThemeAddon($theme));
    }

    public function testInstallVcs()
    {
        $addon = $this->getThemeVcsAddon('test/teste');

        $this->assertTrue($addon->isVcs());

        $this->manager->install($addon);

        $composerJson =  json_decode(file_get_contents(__DIR__ . '/composer.json'));

        $expectedJsonObject = [
            'repositories' => [
                "test" => [
                    "type" => "vcs",
                    "url" => $addon->getRepositoryUrl(),
               ]
            ],
        ];

        $this->assertTrue($composerJson == json_decode(json_encode($expectedJsonObject)));
    }
}
