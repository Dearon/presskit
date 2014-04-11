<?php

namespace Presskit;

class Presskit
{
    private $baseDirectory = '';

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

    public function getData($name)
    {
        if ($name == 'company') {
            $xml = $this->baseDirectory . 'data.xml';
            $data = $this->parser->parse($xml);
        }

        $this->validation->validate($data);
        $data = $this->format->format($data);
        $data['projects'] = $this->files->projects();
        $data['images'] = $this->files->images();
        $data['logo'] = $this->files->logo();

        return $data;
    }
}
