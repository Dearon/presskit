<?php


class Presskit_ParserXMLTest extends PHPUnit_Framework_Testcase
{
    protected $fixtures;
    protected $parser;
    
    protected function setUp()
    {
        $this->fixtures = dirname(__FILE__).'/../../../fixtures/';

        require $this->fixtures.'data/php/company/full.php';
        require $this->fixtures.'data/php/company/minimal.php';
        require $this->fixtures.'data/php/company/invalid.php';

        $this->parser = new \Presskit\Parser\XML();
        $this->companyFullArray = $companyFullArray;
        $this->companyMinimalArray = $companyMinimalArray;
        $this->companyInvalidArray = $companyInvalidArray;
    }

    public function testNoXMLInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument can not be empty');
        $this->parser->parse();
    }

    public function testNoTypeInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The type argument can not be empty');
        $this->parser->parse($this->fixtures.'data/xml/company/full.xml');
    }

    public function testNoFileInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument has to be a file');
        $this->parser->parse('12345');
    }

    public function testInvalidTypeInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The type argument has to be either company or project');
        $this->parser->parse($this->fixtures.'data/xml/company/full.xml', 'invalid');
    }

    public function testBrokenXML()
    {
        $this->setExpectedException('InvalidArgumentException', 'The XML argument has to be valid XML');
        $this->parser->parse($this->fixtures.'data/xml/broken.xml', 'company');
    }

    public function testCompanyFullXML()
    {
        $this->assertEquals($this->companyFullArray, $this->parser->parse($this->fixtures.'data/xml/company/full.xml', 'company'));
    }

    public function testCompanyMinimalXML()
    {
        $this->assertEquals($this->companyMinimalArray, $this->parser->parse($this->fixtures.'data/xml/company/minimal.xml', 'company'));
    }

    public function testCompanyInvalidXML()
    {
        $this->assertEquals($this->companyInvalidArray, $this->parser->parse($this->fixtures.'data/xml/company/invalid.xml', 'company'));
    }
}
