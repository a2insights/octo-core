<?php

namespace Octo\Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public static function setUpBeforeClass(): void
    {
        if (file_exists(__DIR__ . '/../.env')) {
            \Dotenv\Dotenv::createImmutable(__DIR__ . '../..')->load();
        }
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__ . './../config/octo.php';

        $app['config']->set('octo', $config);
    }
}
