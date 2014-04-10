<?php

class Presskit_FilesTest extends PHPUnit_Framework_Testcase
{
    protected $files;

    public function setUp()
    {
        $directory = dirname(__FILE__).'/../../fixtures/files/';
        $this->files = new \Presskit\Files($directory);
    }

    public function testProjects()
    {
        $expected = array(
            array(
                'path' => 'GaMe_2',
                'name' => 'GaMe 2',
            ),
            array(
                'path' => 'game_1',
                'name' => 'Game 1',
            ),
        );
        $this->assertEquals($expected, $this->files->projects());
    }

    public function testImages()
    {
        $expected = array(
            'zip' => array(
                'path' => 'images/images.zip',
                'filesize' => '525KB',
            ),
            'images' => array(
                'images/4415044023_dac059fd3c_o.jpg',
                'images/hood_13746h.jpg',
            ),
        );
        $this->assertEquals($expected, $this->files->images());
    }

    public function testLogo()
    {
        $expected = array(
            'zip' => array(
                'path' => 'images/logo.zip',
                'filesize' => '307KB',
            ),
            'images' => array(
                'images/logo.png',
            ),
        );
        $this->assertEquals($expected, $this->files->logo());
    }
}
