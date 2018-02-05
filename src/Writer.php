<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\Antenna\Exceptions\WriterNotExistsException;
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
     * @return \Illuminate\Foundation\Application|mixed
     * @throws WriterNotExistsException
     */
    public function getStrategy()
    {
        $type = $this->config('handler');

        switch ($type) {
            case 'inform':
                return app(\Bondacom\LaravelFileManager\Writers\Inform::class);
            default:
                throw new WriterNotExistsException($type);
        }
    }
}