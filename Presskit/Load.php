<?php

namespace Presskit;

use \LogicException;

class Load
{
    public $baseDirectory = '';

    public function __construct($baseDirectory = '')
    {
        if ($baseDirectory === '') {
            $baseDirectory = realpath(dirname(__FILE__).'/../') . '/';
        }
        $this->baseDirectory = $baseDirectory;

        $this->parser = new \Presskit\Parser\XML();
        $this->validation = new \Presskit\Validation();
        $this->format = new \Presskit\Format();
        $this->files = new \Presskit\Files($this->baseDirectory);
    }

    public function load($name)
    {
        if ($name == 'company') {
            if (is_file($this->baseDirectory . 'data.xml')) {
                $xml = $this->baseDirectory . 'data.xml';
                $data = $this->parser->parse($xml, 'company');
            } else {
                throw new LogicException('Unable to find required data file');
            }
        } else {
            $name = basename($name);

            if (is_file($this->baseDirectory . $name . '/data.xml')) {
                $xml = $this->baseDirectory . $name . '/data.xml';
                $data = $this->parser->project($xml, 'project');
            } else {
                throw new LogicException('Unable to find required data file');
            }
        }

        $this->validation->validate($data);
        $data = $this->format->format($data);
        $data['projects'] = $this->files->projects();
        $data['images'] = $this->files->images();
        $data['logo'] = $this->files->logo();

        return $data;
    }
}
