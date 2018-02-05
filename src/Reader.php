<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\LaravelFileManager\Exceptions\ReaderNotExistsException;
use Bondacom\LaravelFileManager\Utilities\Utility;

class Reader extends Utility
{
    /**
     * @param string $filepath
     * @return \Bondacom\LaravelFileManager\Readers\Reader
     */
    public function open($filepath)
    {
        return $this->getStrategy()->open($filepath);
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     * @throws ReaderNotExistsException
     */
    protected function getStrategy()
    {
        $type = $this->config('handler');
        $config = $this->config('default');

        switch ($type) {
            case 'txt':
                return app(\Bondacom\LaravelFileManager\Readers\Txt::class)->setConfig($config);
            case 'csv':
                return app(\Bondacom\LaravelFileManager\Readers\Csv::class)->setConfig($config);
            default:
                throw new ReaderNotExistsException($type);
        }
    }
}