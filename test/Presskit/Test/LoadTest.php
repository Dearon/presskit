<?php

class Presskit_LoadTest extends PHPUnit_Framework_Testcase
{
    protected $load;
    protected $loadNoFiles;

    public function setUp()
    {
        $normalDirectory = dirname(__FILE__).'/../../fixtures/load/normal/';
        $noFilesDirectory = dirname(__FILE__).'/../../fixtures/load/nofiles/';

        $this->load = new \Presskit\Load($normalDirectory);
        $this->loadNoFiles = new \Presskit\Load($noFilesDirectory);
    }

    public function testNoFiles()
    {
        $this->setExpectedException('LogicException', 'Unable to find required data file');
        $this->loadNoFiles->load('company');
    }

    public function testNormal()
    {
        $data = $this->load->load('company');
        $this->assertArrayHasKey('title', $data);
    }
}
