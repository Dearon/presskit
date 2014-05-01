<?php

class Presskit_ValidationTest extends PHPUnit_Framework_Testcase
{
    protected $fixtures;
    protected $validation;

    protected function setUp()
    {
        $this->fixtures = dirname(__FILE__).'/../../fixtures/';

        require $this->fixtures.'data/php/company/full.php';
        require $this->fixtures.'data/php/company/minimal.php';
        require $this->fixtures.'data/php/company/invalid.php';
        require $this->fixtures.'validation/invalidWebsite.php';
        require $this->fixtures.'validation/invalidPressContact.php';
        require $this->fixtures.'validation/invalidSocialWebsite.php';
        require $this->fixtures.'validation/invalidQuoteWebsite.php';
        require $this->fixtures.'validation/invalidAdditionalsWebsite.php';
        require $this->fixtures.'validation/invalidCreditWebsite.php';
        require $this->fixtures.'validation/invalidContactWebsite.php';
        require $this->fixtures.'validation/invalidContactMail.php'; 

        $this->validation = new \Presskit\Validation();
        $this->companyFullArray = $companyFullArray;
        $this->companyMinimalArray = $companyMinimalArray;
        $this->companyInvalidArray = $companyInvalidArray;
        $this->invalidWebsiteArray = $invalidWebsiteArray;
        $this->invalidPressContactArray = $invalidPressContactArray;
        $this->invalidSocialWebsiteArray = $invalidSocialWebsiteArray;
        $this->invalidQuoteWebsiteArray = $invalidQuoteWebsiteArray;
        $this->invalidAdditionalsWebsiteArray = $invalidAdditionalsWebsiteArray;
        $this->invalidCreditWebsiteArray = $invalidCreditWebsiteArray;
        $this->invalidContactWebsiteArray = $invalidContactWebsiteArray;
        $this->invalidContactMailArray = $invalidContactMailArray;
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

    public function testCompanyInvalidArray()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array did not contain all the necessary fields');
        $this->validation->validate($this->companyInvalidArray);
    }

    public function testCompanyMinimalArray()
    {
        $this->assertEquals($this->companyMinimalArray, $this->validation->validate($this->companyMinimalArray));
    }

    public function testCompanyFullArray()
    {
        $this->assertEquals($this->companyFullArray, $this->validation->validate($this->companyFullArray));
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

    public function testInvalidCreditWebsite()
    {
        $this->setExpectedException('InvalidArgumentException', 'The credit links need to be a valid urls');
        $this->validation->validate($this->invalidCreditWebsiteArray);
    }

    public function testInvalidContactWebsite()
    {
        $this->setExpectedException('InvalidArgumentException', 'The contact links need to be a valid urls');
        $this->validation->validate($this->invalidContactWebsiteArray);
    }

    public function testInvalidContactMail()
    {
        $this->setExpectedException('InvalidArgumentException', 'The contact mail need to be a valid email address');
        $this->validation->validate($this->invalidContactMailArray);
    }
}
