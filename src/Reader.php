<?php

namespace Bondacom\LaravelFileManager;

use Bondacom\LaravelFileManager\Utilities\Utility;

class Reader extends Utility
{
    /**
     * @return mixed
     */
    public function process()
    {
        return $this->getStrategy()->process();
    }

    /**
     * @return \Illuminate\Foundation\Application|mixed
     * @throws \Exception
     */
    public function getStrategy()
    {
        $type = $this->config('handler');

        switch ($type) {
            case 'txt':
                return app(\Bondacom\LaravelFileManager\Readers\Txt::class);
            case 'csv':
                return app(\Bondacom\LaravelFileManager\Readers\Csv::class);
            default:
                throw new \Exception("Reader Handler {$type} does not exists");
        }
    }
}