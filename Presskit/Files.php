<?php

namespace Presskit;

use \InvalidArgumentException;

class Files
{
    private $baseDirectory;

    public function __construct($directory = '')
    {
        if ($directory === '') {
            $directory = dirname(__FILE__).'/../';
        }
        $this->baseDirectory = $directory;
    }

    public function projects()
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

        $directories = scandir($this->baseDirectory);
        $directories = array_diff($directories, $ignore);

        $projects = array();

        foreach ($directories as $directory) {
            if (is_dir($this->baseDirectory . $directory) && file_exists($this->baseDirectory . $directory . '/data.xml')) {
                $projects[] = array('path' => $directory, 'name' => ucwords(str_replace('_', ' ', $directory)));
            }
        }

        return $projects;
    }
}
