<?php

namespace Presskit;

class Autoloader
{
    private $baseDir;

    public function __construct($baseDir = null)
    {
        if ($baseDir === null) {
            $baseDir = dirname(__FILE__).'/..';
        }

        $realDir = realpath($baseDir) . DIRECTORY_SEPARATOR;
        if (is_dir($realDir)) {
            $this->baseDir = $realDir;
        } else {
            $this->baseDir = $baseDir;
        }
    }

    public function register($baseDir = null)
    {
        $loader = new self($baseDir);
        spl_autoload_register(array($loader, 'autoload'));

        return $loader;
    }

    public function autoload($class)
    {
        $class = ltrim($class, '\\');
        $filename = $this->baseDir;
        $namespace = '';
        if ($lastNsPos = strripos($class, '\\')) {
            $namespace = substr($class, 0, $lastNsPos);
            $class = substr($class, $lastNsPos + 1);
            $filename .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $filename .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

        if (strpos($namespace, 'Presskit') !== 0) {
            return;
        }

        if (file_exists($filename)) {
            require $filename;
        }
    }
}
