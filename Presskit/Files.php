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

    public function images()
    {
        $images = array();

        if (! is_dir($this->baseDirectory . 'images/')) {
            return $images;
        }

        if (file_exists($this->baseDirectory . 'images/images.zip')) {
            $filesize = filesize($this->baseDirectory . 'images/images.zip');

            if ($filesize < 1024) {
                $filesize = '0KB';
            } else if( $filesize >= 1024 && $filesize < 1048576 ) {
		$filesize = (int) ( $filesize / 1024 ) . 'KB';
            }
            if( $filesize > 1048576 ) {
                $filesize = (int) (( $filesize / 1024 ) / 1024 ) . 'MB';
            }

            $images['zip']['path'] = 'images/images.zip';
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


        $files = scandir($this->baseDirectory . 'images/');
        $files = array_diff($files, $ignore);

        foreach ($files as $file) {
            if (is_file($this->baseDirectory . 'images/' . $file)) {
                $finfo = new finfo(FILEINFO_MIME);
                $mime = $finfo->file($this->baseDirectory . 'images/' . $file);

                if (strpos($mime, 'image') !== false) {
                    $images['images'][] = 'images/' . $file;
                }
            }
        }

        return $images;
    }

    public function logo()
    {
        $logo = array();

        if (! is_dir($this->baseDirectory . 'images/')) {
            return $logo;
        }

        if (file_exists($this->baseDirectory . 'images/logo.zip')) {
            $filesize = filesize($this->baseDirectory . 'images/logo.zip');

            if ($filesize < 1024) {
                $filesize = '0KB';
            } else if( $filesize >= 1024 && $filesize < 1048576 ) {
		$filesize = (int) ( $filesize / 1024 ) . 'KB';
            }
            if( $filesize > 1048576 ) {
                $filesize = (int) (( $filesize / 1024 ) / 1024 ) . 'MB';
            }

            $logo['zip']['path'] = 'images/logo.zip';
            $logo['zip']['filesize'] = $filesize;
        }

        if (file_exists($this->baseDirectory . 'images/logo.png')) {
            $logo['images'][] = 'images/logo.png';
        }

        if (file_exists($this->baseDirectory . 'images/icon.png')) {
            $logo['images'][] = 'images/icon.png';
        }

        return $logo;
    }
}
