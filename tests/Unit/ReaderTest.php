<?php

namespace Bondacom\LaravelFileManager\Tests\Unit;

use Bondacom\LaravelFileManager\Readers\Csv;
use Bondacom\LaravelFileManager\Tests\TestCase;

class ReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_process_a_file_line_by_line_by_default()
    {
        $filepath = realpath('tests/helpers').'/oneline.txt';
        $csvReader = app(Csv::class)->open($filepath);

        $csvReader->process(function ($line) {
            $this->assertEquals('testingfile', $line);
        });
    }

    /**
     * @test
     */
    public function it_process_a_file_with_custom_chunk_value()
    {
        $filepath = realpath('tests/helpers').'/oneline.txt';
        $csvReader = app(Csv::class)->open($filepath);

        $csvReader->process(function ($lines) {
            $this->assertEquals(collect(['testingfile']), $lines);
        }, 10);
    }
}
