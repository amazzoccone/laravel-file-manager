<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\LaravelFileManager\Utilities\Utility;

class Writer extends Utility
{
    /**
     * @return mixed
     */
    public function new()
    {
        return $this->getStrategy()->new();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $this->config(['handler' => $name]);
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     * @throws \Exception
     */
    public function getStrategy()
    {
        $type = $this->config('handler');

        switch ($type) {
            case 'inform':
                return app(\Bondacom\LaravelFileManager\Writers\Inform::class);
            default:
                throw new \Exception("Writer Handler {$type} does not exists");
        }
    }
}