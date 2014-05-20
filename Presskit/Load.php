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
        $this->promoter = new \Presskit\Promoter();
        $this->validation = new \Presskit\Validation();
        $this->format = new \Presskit\Format();
        $this->files = new \Presskit\Files($this->baseDirectory);
    }

    public function load($name)
    {
        $companyData = $this->parser->parse($this->baseDirectory . 'data.xml', 'company');
        $this->validation->validate($companyData, 'company');

        if ($name == 'company') {
            $data = $companyData;
            $data['projects'] = $this->files->projects();
            $data['images'] = $this->files->images();
            $data['logo'] = $this->files->logo();
        } else {
            $name = basename($name);
            $data = $this->parser->parse($this->baseDirectory . $name . '/data.xml', 'project');

            if (isset($data['promoter'])) {
                $promoter_data = $this->promoter->promoter($data['promoter']);
                $data = array_merge_recursive($promoter_data, $data);
            }

            $this->validation->validate($data, 'project');

            $data['project-directory'] = $name;
            $data['company-title'] = $companyData['title'];
            $data['company-based-in'] = $companyData['based-in'];
            $data['company-description'] = $companyData['description'];

            if (array_key_exists('analytics', $companyData)) {
                $data['analytics'] = $companyData['analytics'];
            }

            if (array_key_exists('contact', $companyData)) {
                $data['contact'] = $companyData['contact'];
            }

            $data['images'] = $this->files->images($name);
            $data['logo'] = $this->files->logo($name);
        }

        $data = $this->format->format($data);

        return $data;
    }
}
