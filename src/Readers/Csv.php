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
     * @param $column
     * @return \Illuminate\Support\Collection
     */
    public function pluckFile($column)
    {
        $pluckedCollection = collect();

        rewind($this->file);
        if (false === $pos = array_search($column, $this->getHeader())) {
            return $pluckedCollection;
        }

        while ($arrayLine = fgetcsv($this->file, 0, self::VALUE_DELIMITER)) {
            $pluckedCollection->push($arrayLine[$pos]);
        }

        rewind($this->file);
        return $pluckedCollection;
    }


    /**
     * @param \Closure $closureToProcessLines
     * @param $chunkSize
     * @return void
     */
    public function process(\Closure $closureToProcessLines, $chunkSize = null)
    {
        $chunkSize = $chunkSize ?: $this->config('chunk', 1);

        $header = $this->getHeader();
        $headerSize = count($header);

        $lines = collect();
        while ($line = fgetcsv($this->file, 0, self::VALUE_DELIMITER)) {
            if ($chunkSize == 1) {
                $closureToProcessLines($line);
            }
            else {
                //process only lines with same amount of columns as header
                if(count($line) === $headerSize) {
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
     * @return int
     */
    public function totalLines()
    {
        return parent::totalLines() - 1; // Subtract header
    }
}