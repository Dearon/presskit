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

        if (array_key_exists('additionals', $data)) {
            foreach ($data['additionals'] as &$additional) {
                $additional['link-name'] = $this->url($additional['link']);
            }
        }

        if (array_key_exists('contact', $data)) {
            foreach ($data['contact'] as &$contact) {
                if (array_key_exists('link', $contact)) {
                    $contact['link-name'] = $this->url($contact['link']);
                }
            }
        }

        if (array_key_exists('trailers', $data)) {
            $data['trailers'] = $this->trailers($data['trailers']);
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

        if (! empty($url['path']) && $url['path'] != '/') {
            $name = $name . $url['path'];
        }

        return $name;
    }

    private function trailers($trailers)
    {
        foreach ($trailers as &$trailer) {
            if ($trailer['type'] == 'youtube') {
                $trailer['type'] = ucfirst($trailer['type']);
                $trailer['url'] = 'http://www.youtube.com/watch?v=' . $trailer['id'];
                $trailer['embedded'] = '<iframe src="//www.youtube.com/embed/' . $trailer['id'] . '" frameborder="0" allowfullscreen></iframe>';
            }

            if ($trailer['type'] == 'vimeo') {
                $trailer['type'] = ucfirst($trailer['type']);
                $trailer['url'] = 'http://www.vimeo.com/' . $trailer['id'];
                $trailer['embedded'] = '<iframe src="http://player.vimeo.com/video/' . $trailer['id'] . '" frameborder="0" allowfullscreen></iframe>';
            }
        }

        return $trailers;
    }
}
