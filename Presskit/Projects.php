<?php

namespace Presskit;

use \InvalidArgumentException;

class Projects
{
    private $directory;

    public function __construct($directory = '')
    {
        if ($directory === '') {
            $directory = dirname(__FILE__).'/../';
        }
        $this->directory = $directory;
    }

    public function find()
    {
        $ignore = array(
            '.',
            '..',
            'assets',
            'images',
            'Presskit',
            'templates',
            'test',
            'trailers',
            'vendor',
        );

        $directories = scandir($this->directory);
        $directories = array_diff($directories, $ignore);

        $projects = array();

        foreach ($directories as $directory) {
            if (is_dir($this->directory . $directory) && file_exists($this->directory . $directory . '/data.xml')) {
                $projects[] = array('path' => $directory, 'name' => ucwords(str_replace('_', ' ', $directory)));
            }
        }

        return $projects;
    }
}
