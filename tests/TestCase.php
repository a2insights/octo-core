<?php

namespace Octo\Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment before each test.
     */
    public static function setUpBeforeClass(): void
    {
        if (file_exists(__DIR__ . '/../.env')) {
            \Dotenv\Dotenv::createImmutable(__DIR__ . '../..')->load();
        }
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__ . './../config/octo.php';

        $app['config']->set('octo', $config);

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => __DIR__.'/database.sqlite',
            'prefix'   => '',
        ]);
    }

    /**
     * Reset the database.
     *
     * @return void
     */
    protected function resetDatabase()
    {
        file_put_contents(__DIR__.'/database.sqlite', null);
    }
}
