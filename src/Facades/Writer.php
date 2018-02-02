<?php

namespace Bondacom\LaravelFileManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Writer
 * @see \Bondacom\LaravelFileManager\Utilities\Writer
 *
 */
class Writer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Writer';
    }
}