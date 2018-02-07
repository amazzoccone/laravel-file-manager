<?php

namespace Bondacom\LaravelFileManager\Writers;

class Txt extends Writer
{
    /**
     * @param array $params
     * @return $this
     */
    public function add(...$params)
    {
        $content = (string)($params[0] ?? '');
        $newLine = (bool)($params[1] ?? true);

        fputs($this->fp, $content . ($newLine ? PHP_EOL : ''));

        return $this;
    }
}