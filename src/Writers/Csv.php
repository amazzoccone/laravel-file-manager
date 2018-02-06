<?php

namespace Bondacom\LaravelFileManager\Writers;

class Csv extends Writer
{
    /**
     * @param array $content
     * @return $this
     */
    public function add(array $content)
    {
        fputcsv($this->fp, $content);

        return $this;
    }
}