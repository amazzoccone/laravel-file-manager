<?php

namespace Bondacom\LaravelFileManager\Exceptions;

use Throwable;

class ReaderNotExistsException extends \Exception
{
    public function __construct($type, $code = 0, Throwable $previous = null)
    {
        $message = "Reader handler {$type} does not exists";

        parent::__construct($message, $code, $previous);
    }
}