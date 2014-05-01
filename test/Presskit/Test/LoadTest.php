<?php

class Presskit_LoadTest extends PHPUnit_Framework_Testcase
{
    protected $fixtures;
    protected $load;
    protected $loadEmpty;

    public function setUp()
    {
        $this->fixtures = dirname(__FILE__).'/../../fixtures/';

        $normalDirectory = $this->fixtures.'data/presskit/';
        $emptyDirectory = $this->fixtures.'data/presskit_empty/';

        $this->load = new \Presskit\Load($normalDirectory);
        $this->loadEmpty = new \Presskit\Load($emptyDirectory);
    }

    public function testNoFiles()
    {
        $this->setExpectedException('LogicException', 'Unable to find required data file');
        $this->loadEmpty->load('company');
    }

    public function testNormal()
    {
        $data = $this->load->load('company');
        $this->assertArrayHasKey('title', $data);
    }
}
