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

        // Create file
        // "a": Open for writing only; place the file pointer at the end of the file.
        //      If the file does not exist, attempt to create it. )
        $localFilePath = config('filesystems.disks.local.root') . '/' . $this->filename;
        $this->fp = fopen($localFilePath, "a");

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