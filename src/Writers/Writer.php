<?php

namespace Bondacom\LaravelFileManager\Writers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

abstract class Writer
{
    /**
     * @var File Pointer
     */
    protected $fp;

    /**
     * @var string
     */
    protected $filename;

    /**
     * Create file and directory if not exists
     *
     * @param string $filename (Ex.: imports/test_8439810439.log)
     * @return $this
     */
    public function new(string $filename)
    {
        $this->filename = $filename;

        $this->checkDirectoryExists();

        // Create file
        // "a": Open for writing only; place the file pointer at the end of the file.
        //      If the file does not exist, attempt to create it. )
        $localFilePath = config('filesystems.disks.local.root') . '/' . $this->filename;
        $this->fp = fopen($localFilePath, "a");

        return $this;
    }

    /**
     * @param string $content
     * @param bool $newLine
     * @return $this
     */
    public function add(string $content, $newLine = true)
    {
        fputs($this->fp, $content . ($newLine ? PHP_EOL : ''));

        return $this;
    }

    /**
     * @return boolean true on success or false on failure.
     */
    public function save()
    {
        $result = fclose($this->fp);

        if (!$result) {
            return false;
        }

        if (config('filesystems.default') != 's3') {
            return true;
        }

        return $this->moveFileToS3();
    }

    /**
     * @return bool true on success or false on failure.
     */
    private function moveFileToS3()
    {
        $result = Storage::put($this->filename, Storage::disk('local')->get($this->filename));
        if (!$result) {
            return false;
        }

        $deleted = Storage::disk('local')->delete($this->filename);
        if (!$deleted) {
            Log::error('Cannot delete local file');
        }

        return true;
    }

    /**
     * @return $this
     */
    private function checkDirectoryExists()
    {
        $path = dirname($this->filename);

        if (!Storage::disk('local')->exists($path)) {
            Storage::disk('local')->makeDirectory($path);
        }

        return $this;
    }
}