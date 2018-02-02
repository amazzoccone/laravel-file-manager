<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\LaravelFileManager\Utilities\Utility;

class Writer extends Utility
{
    /**
     * @param string $filepath
     * @return mixed
     */
    public function new(string $filepath)
    {
        return $this->getStrategy()->new($filepath);
    }

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