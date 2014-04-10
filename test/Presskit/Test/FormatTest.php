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

    public function testAdditionalsLink()
    {
        $input = array('additionals' => array(array('description' => 'Description', 'name' => 'Name', 'website' => 'Website', 'link' => 'http://www.website.com/')));
        $expected = array('additionals' => array(array('description' => 'Description', 'name' => 'Name', 'website' => 'Website', 'link' => 'http://www.website.com/', 'link-name' => 'website.com')));
        $this->assertEquals($expected, $this->format->format($input));
    }

    public function testTrailers()
    {
        $input = array(
            'trailers' => array(
                array(
                    'name' => 'Youtube video',
                    'type' => 'youtube',
                    'id' => '7jQbITg0MSk',
                ),
                array(
                    'name' => 'Vimeo video',
                    'type' => 'vimeo',
                    'id' => '12536488',
                ),
            ),
        );
        $expected = array(
            'trailers' => array(
                array(
                    'name' => 'Youtube video',
                    'type' => 'Youtube',
                    'id' => '7jQbITg0MSk',
                    'url' => 'http://www.youtube.com/watch?v=7jQbITg0MSk',
                    'embedded' => '<iframe src="//www.youtube.com/embed/7jQbITg0MSk" frameborder="0" allowfullscreen></iframe>',
                ),
                array(
                    'name' => 'Vimeo video',
                    'type' => 'Vimeo',
                    'id' => '12536488',
                    'url' => 'http://www.vimeo.com/12536488',
                    'embedded' => '<iframe src="http://player.vimeo.com/video/12536488" frameborder="0" allowfullscreen></iframe>',
                ),
            ),
        );
        $this->assertEquals($expected, $this->format->format($input));
    }
}
