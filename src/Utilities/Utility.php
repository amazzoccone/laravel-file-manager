<?php

namespace Bondacom\LaravelFileManager\Utilities;

abstract class Utility
{
    use Configurable;

    /**
     * File constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    abstract protected function getStrategy();

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $this->config(['handler' => $name]);

        return $this;
    }
}