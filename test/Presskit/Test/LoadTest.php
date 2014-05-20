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
        $this->setExpectedException('InvalidArgumentException', 'The XML argument has to be a file');
        $this->loadEmpty->load('company');
    }

    public function testNoProjectFiles()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument has to be a file');
        $this->load->load('game3');
    }

    public function testCompany()
    {
        $data = $this->load->load('company');
        $this->assertArrayHasKey('title', $data);
    }

    public function testProject()
    {
        $data = $this->load->load('game_1');
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('company-title', $data);
    }
}
