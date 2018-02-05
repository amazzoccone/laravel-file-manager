<?php

namespace Bondacom\LaravelFileManager\Tests\Feature;

use Bondacom\LaravelFileManager\Exceptions\ReaderNotExistsException;
use Bondacom\LaravelFileManager\Facades\Reader;
use Bondacom\LaravelFileManager\Readers\Csv;
use Bondacom\LaravelFileManager\Readers\Txt;
use Bondacom\LaravelFileManager\Tests\TestCase;

class ReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_instance_default_reader_class()
    {
        $this->mock(Txt::class)
            ->shouldReceive('setConfig')->once()->andReturnSelf()
            ->shouldReceive('open')->once()->andReturnSelf();

        $filepath = getcwd();
        $reader = Reader::open($filepath);

        $this->assertInstanceOf(Txt::class, $reader);
    }

    /**
     * @test
     */
    public function it_should_instance_other_reader_class()
    {
        $this->mock(Csv::class)
            ->shouldReceive('setConfig')->once()->andReturnSelf()
            ->shouldReceive('open')->once()->andReturnSelf();

        $filepath = getcwd();
        $reader = Reader::csv()->open($filepath);

        $this->assertInstanceOf(Csv::class, $reader);
    }

    /**
     * @test
     */
    public function it_should_throws_an_exception_if_reader_class_not_exists()
    {
        $filepath = getcwd();

        $this->expectException(ReaderNotExistsException::class);
        Reader::csb()->open($filepath);
    }
}
