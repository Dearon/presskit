<?php

class Presskit_PromoterTest extends PHPUnit_Framework_Testcase
{
    protected $promoter;

    public function setUp()
    {
        $this->promoter = new \Presskit\Promoter();
    }

    public function testNoPromoterCode()
    {
        $this->setExpectedException('InvalidArgumentException', 'The promoter code can not be empty');
        $this->promoter->promoter();
    }

    public function test404()
    {
        $this->setExpectedException('InvalidArgumentException', 'The promoter app has no data for that code');
        $this->promoter->promoter(9999);
    }
}
