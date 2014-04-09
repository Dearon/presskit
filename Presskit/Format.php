<?php

namespace Presskit;

use \InvalidArgumentException;

class Format
{
    public function format($data = array())
    {
        if (! is_array($data)) {
            throw new InvalidArgumentException('The data array must be an array');
        }

        if (empty($data)) {
            throw new InvalidArgumentException('The data array can not be empty');
        }

        if (array_key_exists('website', $data)) {
            $data['website-name'] = $this->url($data['website']);
        }

        return $data;
    }

    private function url($url)
    {
        $url = parse_url($url);

        if (substr($url['host'], 0, 4) == 'www.') {
            $name = substr($url['host'], 4);
        } else {
            $name = $url['host'];
        }

        return $name;
    }
}
