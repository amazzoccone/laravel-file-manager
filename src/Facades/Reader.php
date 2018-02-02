<?php

namespace Bondacom\LaravelFileManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Reader
 * @see \Bondacom\LaravelFileManager\Utilities\Reader
 *
 */
class Reader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Reader';
    }
}