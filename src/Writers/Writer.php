<?php

namespace Bondacom\LaravelFileManager\Writers;

use Bondacom\LaravelFileManager\Utilities\Configurable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

abstract class Writer
{
    use Configurable;

    /**
     * @var File Pointer
     */
    protected $fp;

    /**
     * @var string
     */
    protected $filename;

    /**
     * Writer constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param array $params
     * @return $this
     */
    abstract public function add(...$params);

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

        // "a": Open for writing only; place the file pointer at the end of the file.
        //      If the file does not exist, attempt to create it. )
        $this->fp = fopen($this->filename, "a");

        return $this;
    }

    /**
     * @return boolean true on success or false on failure.
     */
    public function save()
    {
        $result = fclose($this->fp);

        if (!$result) {
            Log::error('Cannot close file pointer');
            return false;
        }

        if ($this->config('move_to_s3')) {
            return $this->moveFileToS3();
        }

        return true;
    }

    /**
     * @return bool true on success or false on failure.
     */
    private function moveFileToS3()
    {
        $storageFilename = str_replace(config('filesystems.disks.local.root'), '', $this->filename);

        $result = Storage::disk('s3')->put($storageFilename, file_get_contents($this->filename));
        if (!$result) {
            Log::error('Cannot move local file to s3');
            return false;
        }

        $deleted = unlink($this->filename);
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

        if (!is_dir($path)) {
            mkdir($path);
        }

        return $this;
    }
}