<?php

class Presskit_AutoloaderTest extends PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $loader = \Presskit\Autoloader::register();
        $this->assertTrue(spl_autoload_unregister(array($loader, 'autoload')));
    }

    public function testAutoload()
    {
        $loader = \Presskit\Autoloader::register(dirname(__FILE__).'/../../fixtures/autoloader');

        $this->assertNull($loader->autoload('DifferentClass'));
        $this->assertFalse(class_exists('DifferentClass'));

        $this->assertNull($loader->autoload('\Presskit\Presskit'));
        $this->assertTrue(class_exists('\Presskit\Presskit'));
    }
}
