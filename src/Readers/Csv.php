<?php

namespace Bondacom\LaravelFileManager\Readers;

//TODO: Should implement an interface
class Csv extends Reader
{
    const VALUE_DELIMITER = ',';

    /**
     * Get the file's header
     *
     * @param $file
     * @return array
     */
    public function getHeader($file)
    {
        $firstLine = $this->getFirstLine($file);
        return explode(self::VALUE_DELIMITER, $firstLine);
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
     * @param $file
     * @param $chunkSize
     * @param \Closure $closureToProcessLines
     * @return void
     */
    public function processFileInChunks($file, $chunkSize, \Closure $closureToProcessLines)
    {

        $header = $this->getHeader($file);
        $headerSize = count($header);

        $arrayLines = collect();
        while ($line = fgetcsv($file, 0, self::VALUE_DELIMITER)) {

            if(count($line) === $headerSize){
                $arrayLines->push(array_combine($header, $line));
            }

            if ($arrayLines->count() == $chunkSize) {
                $closureToProcessLines($arrayLines);
                $arrayLines = collect();
            }
        }

        if ($arrayLines->count()) {
            $closureToProcessLines($arrayLines);
        }

        rewind($file);
    }

    /**
     * @param $file
     * @return int
     */
    public function getTotalRowsOfFile($file)
    {
        return parent::getTotalRowsOfFile($file) - 1; // Subtract header
    }
}