<?php

class Presskit_ValidationTest extends PHPUnit_Framework_Testcase
{
    protected $validation;

    protected function setUp()
    {
        require dirname(__FILE__).'/../../fixtures/parser/fullValid.php';
        require dirname(__FILE__).'/../../fixtures/parser/minimalValid.php';
        require dirname(__FILE__).'/../../fixtures/parser/invalid.php';
        require dirname(__FILE__).'/../../fixtures/validation/invalidWebsite.php';
        require dirname(__FILE__).'/../../fixtures/validation/invalidPressContact.php';
        require dirname(__FILE__).'/../../fixtures/validation/invalidSocialWebsite.php';
        require dirname(__FILE__).'/../../fixtures/validation/invalidQuoteWebsite.php';
        require dirname(__FILE__).'/../../fixtures/validation/invalidAdditionalsWebsite.php';

        $this->validation = new \Presskit\Validation();
        $this->fullValidArray = $fullValidArray;
        $this->minimalValidArray = $minimalValidArray;
        $this->invalidArray = $invalidArray;
        $this->invalidWebsiteArray = $invalidWebsiteArray;
        $this->invalidPressContactArray = $invalidPressContactArray;
        $this->invalidSocialWebsiteArray = $invalidSocialWebsiteArray;
        $this->invalidQuoteWebsiteArray = $invalidQuoteWebsiteArray;
        $this->invalidAdditionalsWebsiteArray = $invalidAdditionalsWebsiteArray;
    }

    public function testNoInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array can not be empty');
        $this->validation->validate();
    }

    public function testStringInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array must be an array');
        $this->validation->validate('A string');
    }

    public function testInvalidArray()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array did not contain all the necessary fields');
        $this->validation->validate($this->invalidArray);
    }

    public function testMinimalValidArray()
    {
        $this->assertEquals($this->minimalValidArray, $this->validation->validate($this->minimalValidArray));
    }

    public function testFullValidArray()
    {
        $this->assertEquals($this->fullValidArray, $this->validation->validate($this->fullValidArray));
    }

    public function testInvalidWebsite()
    {
        $this->setExpectedException('InvalidArgumentException', 'The website needs to be a valid url');
        $this->validation->validate($this->invalidWebsiteArray);
    }

    public function testInvalidPressContact()
    {
        $this->setExpectedException('InvalidArgumentException', 'The press contact needs to be a valid email address');
        $this->validation->validate($this->invalidPressContactArray);
    }

    public function testInvalidSocialWebsite()
    {
        $this->setExpectedException('InvalidArgumentException', 'The social links need to be a valid urls');
        $this->validation->validate($this->invalidSocialWebsiteArray);
    }

    public function testInvalidQuoteWebsite()
    {
        $this->setExpectedException('InvalidArgumentException', 'The quote links need to be a valid urls');
        $this->validation->validate($this->invalidQuoteWebsiteArray);
    }

    public function testInvalidAdditionalsWebsite()
    {
        $this->setExpectedException('InvalidArgumentException', 'The additional links need to be a valid urls');
        $this->validation->validate($this->invalidAdditionalsWebsiteArray);
    }
}
