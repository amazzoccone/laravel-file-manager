<?php

namespace Bondacom\LaravelFileManager\Readers;

//TODO: Should implement an interface
class Csv extends Reader
{
    const VALUE_DELIMITER = ',';

    /**
     * @return array
     */
    public function getHeader()
    {
        return explode(self::VALUE_DELIMITER, $this->getFirstLine());
    }

    /**
     * Get the values from specified column
     *
     * @param $file
     * @param $column
     * @return \Illuminate\Support\Collection
     */
    public function pluckFile($file, $column)
    {
        $pluckedCollection = collect();

        rewind($file);
        if (false === $pos = array_search($column, $this->getHeader($file))) {
            return $pluckedCollection;
        }

        while ($arrayLine = fgetcsv($file, 0, self::VALUE_DELIMITER)) {
            $pluckedCollection->push($arrayLine[$pos]);
        }

        rewind($file);
        return $pluckedCollection;
    }


    /**
     * @param \Closure $closureToProcessLines
     * @param $chunkSize
     * @return void
     */
    public function process(\Closure $closureToProcessLines, $chunkSize)
    {
        $header = $this->getHeader();
        $headerSize = count($header);

        $lines = collect();
        while ($line = fgetcsv($this->file, 0, self::VALUE_DELIMITER)) {
            if ($chunkSize == 1) {
                $closureToProcessLines($line);
            }
            else {
                if(count($line) === $headerSize){
                    $lines->push(array_combine($header, $line));
                }

                if ($lines->count() == $chunkSize) {
                    $closureToProcessLines($lines);
                    $lines = collect();
                }
            }
        }

        //process last lines (smaller than $chunkSize)
        if ($lines->count()) {
            $closureToProcessLines($lines);
        }

        rewind($this->file);
    }

    /**
     * @param $file
     * @return int
     */
    public function totalLines($file)
    {
        return parent::totalLines($file) - 1; // Subtract header
    }
}