<?php

namespace Octo\Concerns;

use Symfony\Component\Process\Process;

trait InteractWithComposer {

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param mixed $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $this->comand('require', $packages);
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param mixed $packages
     * @return void
     */
    protected function removeComposerPackages($packages)
    {
        $this->comand('remove', $packages);
    }

    /**
     * Execute composer comand.
     *
     * @param string $command
     * @param mixed $packages
     * @return void
     */
    public function comand($command, $packages = [])
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $commandArr = ['php', $composer, $command];
        }

        $commands = array_merge(
            $commandArr ?? ['composer', $command],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($commands, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}
