<?php

namespace Octo\Console\Concerns;

use Symfony\Component\Process\Process;

trait InteractWithComposer
{
    /**
     * Installs the given Composer Packages into the application.
     *
     * @param mixed $packages
     * @param string $workingPath
     * @return void
     */
    protected function requireComposerPackages($packages, $workingPath = null)
    {
        $this->composer('require', $workingPath ?? base_path(), $packages);
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param mixed $packages
     * @param string $workingPath
     * @return void
     */
    protected function removeComposerPackages($packages, $workingPath = null)
    {
        $this->composer('remove', $workingPath ?? base_path(), $packages);
    }

    /**
    * Update the given Composer Packages into the application.
    *
    * @param string $workingPath
    * @return void
    */
    protected function updateComposerPackages($workingPath = null)
    {
        $this->composer(['update'], $workingPath ?? base_path());
    }

    /**
     * Execute composer comand.
     *
     * @param array $command
     * @param string $workingPath
     * @param mixed $packages
     * @return void
     */
    public function composer($command, $workingPath, $packages = [])
    {
        $composer = 'global';

        if ($composer !== 'global') {
            $commandArr = ['php', $composer, $command];
        }

        $commands = array_merge(
            $commandArr ?? ['composer'],
            $command,
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($commands, $workingPath, ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}
