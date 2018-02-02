<?php

namespace Bondacom\LaravelFileManager\Utilities;

class Bom
{
    /**
     * @param string $value
     * @return bool
     */
    public function has(string $value)
    {
        return substr($value, 0, 3) == "\xef\xbb\xbf";
    }

    /**
     * @param string $value
     * @return string
     */
    public function filter(string $value)
    {
        if ($this->has($value)) {
            return substr($value, 3);
        }

        return $value;
    }
}