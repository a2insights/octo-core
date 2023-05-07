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

        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
