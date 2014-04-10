<?php

class Presskit_ProjectsTest extends PHPUnit_Framework_Testcase
{
    protected $projects;

    public function setUp()
    {
        $directory = dirname(__FILE__).'/../../fixtures/projects/';
        $this->projects = new \Presskit\projects($directory);
    }

    public function testDirectories()
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
        $this->assertEquals($expected, $this->projects->find());
    }
}
