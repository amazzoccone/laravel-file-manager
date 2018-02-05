<?php

namespace Bondacom\Antenna\Exceptions;

use Throwable;

class WriterNotExistsException extends \Exception
{
    public function __construct($type, $code = 0, Throwable $previous = null)
    {
        $message = "Writer handler {$type} does not exists";

        parent::__construct($message, $code, $previous);
    }
}