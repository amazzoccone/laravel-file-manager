<?php

namespace Bondacom\LaravelFileManager\Writers;

class Csv extends Writer
{
    /**
     * @param array $params
     * @return $this
     */
    public function add(...$params)
    {
        $content = (array)($params[0] ?? []);

        fputcsv($this->fp, $content);

        return $this;
    }
}