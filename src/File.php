<?php

namespace Bondacom\LaravelFileManager;

class File
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
     * 
     */
    public function process()
    {
        //
    }

    /**
     *
     */
    public function __call()
    {
        //Check for handlers

        return $this;
    }
}