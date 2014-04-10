<?php

class Presskit_FilesTest extends PHPUnit_Framework_Testcase
{
    protected $files;

    public function setUp()
    {
        $directory = dirname(__FILE__).'/../../fixtures/projects/';
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
}
