<?php

namespace Presskit;

use \InvalidArgumentException;
use \finfo;

class Files
{
    private $baseDirectory;

    public function __construct($baseDirectory)
    {
        $this->baseDirectory = $baseDirectory;
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

    public function images($project = false)
    {
        $images = array();

        if ($project) {
            $directory = $project . '/images/';
        } else {
            $directory = 'images/';
        }

        if (! is_dir($this->baseDirectory . $directory)) {
            return $images;
        }

        if (file_exists($this->baseDirectory . $directory . 'images.zip')) {
            $filesize = filesize($this->baseDirectory . $directory . 'images.zip');

            if ($filesize < 1024) {
                $filesize = '0KB';
            } else if( $filesize >= 1024 && $filesize < 1048576 ) {
		$filesize = (int) ( $filesize / 1024 ) . 'KB';
            }
            if( $filesize > 1048576 ) {
                $filesize = (int) (( $filesize / 1024 ) / 1024 ) . 'MB';
            }

            $images['zip']['path'] = $directory . 'images.zip';
            $images['zip']['filesize'] = $filesize;
        }

        $ignore = array(
            '.',
            '..',
            'header.png',
            'icon.png',
            'images.zip',
            'logo.png',
            'logo.zip',
        );


        $files = scandir($this->baseDirectory . $directory);
        $files = array_diff($files, $ignore);

        foreach ($files as $file) {
            if (is_file($this->baseDirectory . $directory . $file)) {
                $finfo = new finfo(FILEINFO_MIME);
                $mime = $finfo->file($this->baseDirectory . $directory . $file);

                if (strpos($mime, 'image') !== false) {
                    $images['images'][] = $directory . $file;
                }
            }
        }

        return $images;
    }

    public function logo($project = false)
    {
        $logo = array();

        if ($project) {
            $directory = $project . '/images/';
        } else {
            $directory = 'images/';
        }

        if (! is_dir($this->baseDirectory . $directory)) {
            return $logo;
        }

        if (file_exists($this->baseDirectory . $directory . 'logo.zip')) {
            $filesize = filesize($this->baseDirectory . $directory . 'logo.zip');

            if ($filesize < 1024) {
                $filesize = '0KB';
            } else if( $filesize >= 1024 && $filesize < 1048576 ) {
		$filesize = (int) ( $filesize / 1024 ) . 'KB';
            }
            if( $filesize > 1048576 ) {
                $filesize = (int) (( $filesize / 1024 ) / 1024 ) . 'MB';
            }

            $logo['zip']['path'] = $directory . 'logo.zip';
            $logo['zip']['filesize'] = $filesize;
        }

        if (file_exists($this->baseDirectory . $directory . 'logo.png')) {
            $logo['images'][] = $directory . 'logo.png';
        }

        if (file_exists($this->baseDirectory . $directory . 'icon.png')) {
            $logo['images'][] = $directory . 'icon.png';
        }

        return $logo;
    }
}
