<?php

class Presskit_FormatTest extends PHPUnit_Framework_Testcase
{
    protected $format;

    public function setUp()
    {
        $this->format = new \Presskit\Format();
    }

    public function testNoInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array can not be empty');
        $this->format->format();
    }

    public function testStringInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array must be an array');
        $this->format->format('A string');
    }

    public function testLink()
    {
        $input = array('website' => 'http://www.website.com/');
        $expected = array('website' => 'http://www.website.com/', 'website-name' => 'website.com');
        $this->assertEquals($expected, $this->format->format($input));
    }
}
