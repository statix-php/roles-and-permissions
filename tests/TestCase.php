<?php

namespace Statix\Sentra\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Statix\Sentra\SentraServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            SentraServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //
    }
}
