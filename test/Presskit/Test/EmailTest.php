<?php

class Presskit_EmailTest extends PHPUnit_Framework_Testcase
{
    protected $email;

    public function setUp()
    {
        $this->email = new \Presskit\Email(true);
    }

    public function testInvalidTo()
    {
        $this->setExpectedException('InvalidArgumentException', 'The to email address needs to be a valid email address');
        $this->email->email('invalid', 'test@test.com', 'test', 'test');
    }

    public function testInvalidFrom()
    {
        $this->setExpectedException('InvalidArgumentException', 'The from email address needs to be a valid email address');
        $this->email->email('test@test.com', 'invalid', 'test', 'test');
    }

    public function testEmptyOutlet()
    {
        $this->setExpectedException('InvalidArgumentException', 'The outlet field can not be empty');
        $this->email->email('test@test.com', 'test@test.com', '', 'test');
    }

    public function testEmptyGametitle()
    {
        $this->setExpectedException('InvalidArgumentException', 'The gametitle field can not be empty');
        $this->email->email('test@test.com', 'test@test.com', 'test', '');
    }

    public function testEmail()
    {
        $this->assertEquals(true, $this->email->email('test@test.com', 'test@test.com', 'test', 'test'));
    }
}
