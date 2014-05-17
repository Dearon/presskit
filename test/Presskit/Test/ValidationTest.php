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

        require $this->fixtures.'data/php/project/full.php';
        require $this->fixtures.'data/php/project/minimal.php';
        require $this->fixtures.'data/php/project/invalid.php';

        require $this->fixtures.'validation.php';

        $this->validation = new \Presskit\Validation();

        $this->companyFullArray = $companyFullArray;
        $this->companyMinimalArray = $companyMinimalArray;
        $this->companyInvalidArray = $companyInvalidArray;
        $this->companyRequired = $compayRequired;

        $this->projectFullArray = $projectFullArray;
        $this->projectMinimalArray = $projectMinimalArray;
        $this->projectInvalidArray = $projectInvalidArray;
        $this->projectRequired = $projectRequired;
    }

    public function testNoDataInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array can not be empty');
        $this->validation->validate();
    }

    public function testNoTypeInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The type argument has to be either company or project');
        $this->validation->validate($this->companyFullArray);
    }

    public function testStringInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array must be an array');
        $this->validation->validate('A string', 'company');
    }

    public function testInvalidTypeInput()
    {
        $this->setExpectedException('InvalidArgumentException', 'The type argument has to be either company or project');
        $this->validation->validate($this->companyFullArray, 'invalid');
    }

    public function testCompanyInvalidArray()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array did not contain all the necessary fields');
        $this->validation->validate($this->companyInvalidArray, 'company');
    }

    public function testCompanyMinimalArray()
    {
        $this->assertEquals($this->companyMinimalArray, $this->validation->validate($this->companyMinimalArray, 'company'));
    }

    public function testCompanyFullArray()
    {
        $this->assertEquals($this->companyFullArray, $this->validation->validate($this->companyFullArray, 'company'));
    }

    public function testCompanyInvalidWebsite()
    {
        $array = array_merge_recursive($this->companyRequired, array('website' => 'www.website'));
        $this->setExpectedException('InvalidArgumentException', 'The website needs to be a valid url');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidPressContact()
    {
        $array = array_merge_recursive($this->companyRequired, array('press-contact' => '@company.com'));
        $this->setExpectedException('InvalidArgumentException', 'The press contact needs to be a valid email address');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidSocialWebsite()
    {
        $array = array_merge_recursive($this->companyRequired, array(
            'social' => array(
                array(
                'name' => 'Valid',
                'link' => 'http://www.test.com',
                ),
                array(
                    'name' => 'callto is also valid',
                    'link' => 'callto:test',
                ),
                array(
                    'name' => 'Invalid',
                    'link' => 'www.test',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The social links needs to be a valid urls');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidQuoteWebsite()
    {
        $array = array_merge_recursive($this->companyRequired, array(
            'quotes' => array(
                array(
                    'description' => 'Valid',
                    'name' => 'Valid',
                    'website' => 'Test.com',
                    'link' => 'http://www.test.com',
                ),
                array(
                    'description' => 'Invalid',
                    'name' => 'Invalid',
                    'website' => 'Test.com',
                    'link' => 'www.test',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The quote links needs to be a valid urls');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidAdditionalsWebsite()
    {
        $array = array_merge_recursive($this->companyRequired, array(
            'additionals' => array(
                array(
                    'title' => 'Valid',
                    'description' => 'Valid url',
                    'link' => 'http://www.test.com',
                ),
                array(
                    'title' => 'Invalid',
                    'description' => 'Invalid url',
                    'link' => 'test.com',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The additional links needs to be a valid urls');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidCreditWebsite()
    {
        $array = array_merge_recursive($this->companyRequired, array(
            'credits' => array(
                array(
                    'person' => 'Valid',
                    'role' => 'Valid',
                    'website' => 'http://www.test.com',
                ),
                array(
                    'person' => 'Invalid',
                    'role' => 'Invalid',
                    'website' => 'www.test',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The credit links needs to be a valid urls');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidContactWebsite()
    {
        $array = array_merge_recursive($this->companyRequired, array(
            'contact' => array(
                array(
                    'name' => 'Valid link',
                    'link' => 'http://www.test.com',
                ),
                array(
                    'name' => 'Invalid link',
                    'link' => 'test.com',
                ),
                array(
                    'name' => 'Valid mail',
                    'mail' => 'test@test.com',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The contact links needs to be a valid urls');
        $this->validation->validate($array, 'company');
    }

    public function testCompanyInvalidContactMail()
    {
        $array = array_merge_recursive($this->companyRequired, array(
            'contact' => array(
                array(
                    'name' => 'Valid link',
                    'link' => 'http://www.test.com',
                ),
                array(
                    'name' => 'Valid mail',
                    'mail' => 'test@test.com',
                ),
                array(
                    'name' => 'Invalid mail',
                    'mail' => 'test@test',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The contact mail needs to be a valid email address');
        $this->validation->validate($array, 'company');
    }

    public function testProjectInvalidArray()
    {
        $this->setExpectedException('InvalidArgumentException', 'The data array did not contain all the necessary fields');
        $this->validation->validate($this->projectInvalidArray, 'project');
    }

    public function testProjectMinimalArray()
    {
        $this->assertEquals($this->projectMinimalArray, $this->validation->validate($this->projectMinimalArray, 'project'));
    }

    public function testProjectFullArray()
    {
        $this->assertEquals($this->projectFullArray, $this->validation->validate($this->projectFullArray, 'project'));
    }

    public function testProjectInvalidWebsite()
    {
        $array = array_merge_recursive($this->projectRequired, array('website' => 'www.website'));
        $this->setExpectedException('InvalidArgumentException', 'The website needs to be a valid url');
        $this->validation->validate($array, 'project');
    }

    public function testProjectInvalidPlatformsWebsite()
    {
        $array = array_merge_recursive($this->projectRequired, array(
            'platforms' => array(
                array(
                    'name' => 'Valid link',
                    'link' => 'http://www.test.com',
                ),
                array(
                    'name' => 'Invalid link',
                    'link' => 'test.com',
                ),
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The platform links needs to be a valid urls');
        $this->validation->validate($array, 'project');
    }

    public function testProjectInvalidQuoteWebsite()
    {
        $array = array_merge_recursive($this->projectRequired, array(
            'quotes' => array(
                array(
                    'description' => 'Description',
                    'name' => 'Name',
                    'website' => 'Website',
                    'link' => 'www.website',
                )
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The quote links needs to be a valid urls');
        $this->validation->validate($array, 'project');
    }

    public function testProjectInvalidAdditionalWebsite()
    {
        $array = array_merge_recursive($this->projectRequired, array(
            'additionals' => array(
                array(
                    'title' => 'Title',
                    'description' => 'Description',
                    'link' => 'www.somemusicsite',
                )
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The additional links needs to be a valid urls');
        $this->validation->validate($array, 'project');
    }

    public function testProjectInvalidCreditWebsite()
    {
        $array = array_merge_recursive($this->projectRequired, array(
            'credits' => array(
                array(
                    'person' => 'Person',
                    'role' => 'Role',
                    'website' => 'www.site',
                )
            )
        ));
        $this->setExpectedException('InvalidArgumentException', 'The credit links needs to be a valid urls');
        $this->validation->validate($array, 'project');
    }
}
