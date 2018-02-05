<?php

namespace Bondacom\LaravelFileManager\Tests\Feature;

use Bondacom\LaravelFileManager\Exceptions\WriterNotExistsException;
use Bondacom\LaravelFileManager\Facades\Writer;
use Bondacom\LaravelFileManager\Tests\TestCase;
use Bondacom\LaravelFileManager\Writers\Inform;

class WriterTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_instance_default_writer_class()
    {
        $mock = $this->mock(Inform::class)
            ->shouldReceive('setConfig')->once()->andReturnSelf()
            ->shouldReceive('new')->once()->andReturnSelf();

        $filepath = getcwd();
        $reader = Writer::new($filepath);

        $this->assertInstanceOf(Inform::class, $reader);
    }

    /**
     * @test
     */
    public function it_should_instance_other_writer_class()
    {
        $this->mock(Inform::class)
            ->shouldReceive('setConfig')->once()->andReturnSelf()
            ->shouldReceive('new')->once()->andReturnSelf();

        $filepath = getcwd();
        $reader = Writer::inform()->new($filepath);

        $this->assertInstanceOf(Inform::class, $reader);
    }

    /**
     * @test
     */
    public function it_should_throws_an_exception_if_writer_class_not_exists()
    {
        $filepath = getcwd();

        $this->expectException(WriterNotExistsException::class);
        Writer::csb()->new($filepath);
    }
}
