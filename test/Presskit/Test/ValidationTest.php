<?php

class Presskit_ValidationTest extends PHPUnit_Framework_Testcase
{
    protected $validation;

    protected function setUp()
    {
        require dirname(__FILE__).'/../../fixtures/parser/fullValid.php';
        require dirname(__FILE__).'/../../fixtures/parser/minimalValid.php';
        require dirname(__FILE__).'/../../fixtures/parser/invalid.php';

        $this->validation = new \Presskit\Validation();
        $this->fullValidArray = $fullValidArray;
        $this->minimalValidArray = $minimalValidArray;
        $this->invalidArray = $invalidArray;
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
}
