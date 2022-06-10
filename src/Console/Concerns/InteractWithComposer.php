<?php

namespace Octo\Console\Concerns;

use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

trait InteractWithComposer
{
    /**
     * Execute composer comand.
     *
     * @param array $commands
     * @return void
     */
    public function composer($commands)
    {
        $commands = array_merge([$this->phpBinary(), 'composer.phar'], $commands);

        $vars = [
            'COMPOSER_MEMORY_LIMIT' => '-1',
            'COMPOSER_HOME' =>  base_path(),
            'COMPOSER_CACHE_DIR' => '/tmp/composer-cache',
        ];

        (new Process($commands, base_path(), $vars))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }
}
