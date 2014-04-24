<?php


class Presskit_ParserXMLTest extends PHPUnit_Framework_Testcase
{
    protected $parser;
    
    protected function setUp()
    {
        require dirname(__FILE__).'/../../../fixtures/parser/fullValid.php';
        require dirname(__FILE__).'/../../../fixtures/parser/minimalValid.php';
        require dirname(__FILE__).'/../../../fixtures/parser/invalid.php';

        $this->parser = new \Presskit\Parser\XML();
        $this->fullValidArray = $fullValidArray;
        $this->minimalValidArray = $minimalValidArray;
        $this->invalidArray = $invalidArray;
    }

    public function testNoXMLInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument can not be empty');
        $this->parser->parse();
    }

    public function testNoTypeInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The type argument can not be empty');
        $this->parser->parse(dirname(__FILE__).'/../../../fixtures/parser/fullValid.xml');
    }

    public function testNoFileInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument has to be a file');
        $this->parser->parse('12345');
    }

    public function testInvalidTypeInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The type argument has to be either company or project');
        $this->parser->parse(dirname(__FILE__).'/../../../fixtures/parser/fullValid.xml', 'invalid');
    }

    public function testBrokenXML()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument has to be valid XML');
        $this->parser->parse(dirname(__FILE__).'/../../../fixtures/parser/notxml.xml', 'company');
    }

    public function testFullValidXML()
    {
        $this->assertEquals($this->fullValidArray, $this->parser->parse(dirname(__FILE__).'/../../../fixtures/parser/fullValid.xml', 'company'));
    }

    public function testMinimalValidXML()
    {
        $this->assertEquals($this->minimalValidArray, $this->parser->parse(dirname(__FILE__).'/../../../fixtures/parser/minimalValid.xml', 'company'));
    }

    public function testInvalidXML()
    {
        $this->assertEquals($this->invalidArray, $this->parser->parse(dirname(__FILE__).'/../../../fixtures/parser/invalid.xml', 'company'));
    }
}
