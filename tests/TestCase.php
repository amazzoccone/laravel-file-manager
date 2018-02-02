<?php

namespace Bondacom\LaravelFileManager\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $mockRequester;

    /**
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Bondacom\LaravelFileManager\Providers\LaravelFileManagerServiceProvider::class
        ];
    }

    /**
     * @param $class
     * @param array $arguments
     * @return \Mockery\MockInterface
     */
    public function mock($class, array $arguments = null)
    {
        $mock = $arguments ? \Mockery::mock($class, $arguments) : \Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }
}