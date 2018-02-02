<?php

namespace Bondacom\LaravelFileManager\Readers;

abstract class Reader
{
    /**
     * @param $file
     * @param $chunkSize
     * @param \Closure $closureToProcessLines
     * @return void
     */
    public function process($file, $chunkSize, \Closure $closureToProcessLines)
    {
        rewind($file);

        $lines = collect();
        while ($line = fgets($file)) {
            if ($chunkSize == 1) {
                $closureToProcessLines($line);
            }
            else {
                $lines->push($line);

                if($lines->count() == $chunkSize) {
                    $closureToProcessLines($lines);
                    $lines = collect();
                }
            }
        }

        //process last lines (smaller than $chunkSize)
        if ($lines->count()) {
            $closureToProcessLines($lines);
        }

        rewind($file);
    }

    /**
     * Get the rows of the file to process
     *
     * @param $file
     * @return int
     */
    public function getTotalRowsOfFile($file)
    {
        // FIXME: How can we optimize this function?!
        rewind($file);
        $rows = 0;
        while (fgets($file)) {
            $rows++;
        }
        rewind($file);
        return $rows;
    }

    /**
     * Check if file is empty
     *
     * @param $file
     * @return bool
     */
    public function isEmpty($file)
    {
        rewind($file);
        return feof($file);
    }

    /**
     * Check if has exists the specified line in the file
     *
     * @param $file
     * @param $line
     * @return bool
     */
    public function hasLine($file, $line)
    {
        rewind($file);
        $lineFound = false;
        while ($aLine = fgets($file) && !$lineFound) {
            if ($aLine == $line) {
                $lineFound = true;
            }
        }

        rewind($file);
        return $lineFound;
    }

    /**
     * Filter the file by a condition
     *
     * @param $file
     * @param \Closure $filterCondition
     * @return \Illuminate\Support\Collection
     */
    public function filterFile($file, \Closure $filterCondition)
    {
        rewind($file);
        $filteredLines = collect();

        while ($line = fgets($file)) {
            if ($filterCondition($line)) {
                $filteredLines->push($line);
            }
        }

        rewind($file);
        return $filteredLines;
    }

    /**
     * Get the file's first line
     *
     * @param $file
     * @return array
     */
    public function getFirstLine($file)
    {
        rewind($file);
        $firstLine = trim(fgets($file));
        $firstLine = $this->detectAndRemoveBOM($firstLine);

        return $firstLine;
    }

    /**
     * Detect if $string has BOM character and removes it
     *
     * @param $string
     * @return mixed
     */
    public function detectAndRemoveBOM($string)
    {
        if ($this->hasBOMCharacter($string)) {
            $string = substr($string, 3);
        }

        return $string;
    }

    /**
     * Check if $string has BOM character
     *
     * @param $string
     * @return bool
     */
    public function hasBOMCharacter($string)
    {
        return substr($string, 0, 3) == "\xef\xbb\xbf";
    }
}