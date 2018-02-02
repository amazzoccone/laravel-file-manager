<?php

namespace Bondacom\LaravelFileManager\Readers;

use Bondacom\LaravelFileManager\Utilities\Bom;

abstract class Reader
{
    /**
     * @var File Pointer
     */
    protected $file;

    /**
     * @param string $filepath
     * @return $this
     */
    public function open(string $filepath)
    {
        // Fix macOS files
        ini_set('auto_detect_line_endings', true);
        $this->file = fopen($filepath, "r");

        return $this;
    }

    /**
     * @param \Closure $closureToProcessLines
     * @param int $chunkSize
     * @return void
     */
    public function process(\Closure $closureToProcessLines, $chunkSize = 1)
    {
        $this->assertHasFile();
        rewind($this->file);

        $lines = collect();
        while ($line = fgets($this->file)) {
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

        rewind($this->file);
    }

    /**
     * Get the rows of the file to process
     *
     * @return int
     */
    public function getTotalRowsOfFile()
    {
        $this->assertHasFile();
        // FIXME: How can we optimize this function?!
        rewind($this->file);
        $rows = 0;
        while (fgets($this->file)) {
            $rows++;
        }
        rewind($this->file);
        return $rows;
    }

    /**
     * Check if file is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        $this->assertHasFile();
        rewind($this->file);
        return feof($this->file);
    }

    /**
     * Check if has exists the specified line in the file
     *
     * @param $line
     * @return bool
     */
    public function hasLine($line)
    {
        $this->assertHasFile();
        rewind($this->file);
        $lineFound = false;
        while ($aLine = fgets($this->file) && !$lineFound) {
            if ($aLine == $line) {
                $lineFound = true;
            }
        }

        rewind($this->file);
        return $lineFound;
    }

    /**
     * Filter the file by a condition
     *
     * @param \Closure $filterCondition
     * @return \Illuminate\Support\Collection
     */
    public function filterFile(\Closure $filterCondition)
    {
        $this->assertHasFile();
        rewind($this->file);
        $filteredLines = collect();

        while ($line = fgets($this->file)) {
            if ($filterCondition($line)) {
                $filteredLines->push($line);
            }
        }

        rewind($this->file);
        return $filteredLines;
    }

    /**
     * @return string
     */
    public function getFirstLine()
    {
        $this->assertHasFile();
        rewind($this->file);
        $firstLine = trim(fgets($this->file));
        $firstLine = app(Bom::class)->filter($firstLine);

        return $firstLine;
    }

    /**
     * @throws \Exception
     * @return $this
     */
    private function assertHasFile()
    {
        if (!$this->file) {
            throw new \Exception("You must first open file");
        }

        return $this;
    }
}