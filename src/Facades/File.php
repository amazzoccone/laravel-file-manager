<?php

namespace Bondacom\LaravelFileManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Antenna
 * @see \Bondacom\LaravelFileManager\File
 *
 */
class File extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'File';
    }
}