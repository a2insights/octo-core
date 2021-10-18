<?php

namespace Octo\Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
        if (file_exists(__DIR__ . '/../.env')) {
            \Dotenv\Dotenv::createImmutable(__DIR__ . '../..' )->load();
        }

        $config = require __DIR__ . './../config/octo.php';

        $app['config']->set('octo', $config);
    }
}
