<?php

namespace Bondacom\LaravelFileManager\Utilities;


class Utility
{
    /**
     * @var array
     */
    private $config;

    /**
     * File constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function config(string $key)
    {
        return $this->config[$key] ?? null;
    }
}