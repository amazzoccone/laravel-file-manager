<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\LaravelFileManager\Exceptions\WriterNotExistsException;
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
        $config = $this->config('default');

        switch ($type) {
            case 'txt':
                return app(\Bondacom\LaravelFileManager\Writers\Txt::class)->setConfig($config);
            case 'csv':
                return app(\Bondacom\LaravelFileManager\Writers\Csv::class)->setConfig($config);
            default:
                throw new WriterNotExistsException($type);
        }
    }
}