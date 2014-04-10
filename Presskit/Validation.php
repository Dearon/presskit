<?php

namespace Presskit;

use \InvalidArgumentException;

class Validation
{
    public function validate($data = array())
    {
        if (! is_array($data)) {
            throw new InvalidArgumentException('The data array must be an array');
        }

        if (empty($data)) {
            throw new InvalidArgumentException('The data array can not be empty');
        }

        $invalid = false;

        if (! array_key_exists('title', $data)) $invalid = true;
        if (! array_key_exists('founding-date', $data)) $invalid = true;
        if (! array_key_exists('website', $data)) $invalid = true;
        if (! array_key_exists('based-in', $data)) $invalid = true;
        if (! array_key_exists('press-contact', $data)) $invalid = true;
        if (! array_key_exists('phone', $data)) $invalid = true;
        if (! array_key_exists('description', $data)) $invalid = true;

        if ($invalid) {
            throw new InvalidArgumentException('The data array did not contain all the necessary fields');
        }

        if (! filter_var($data['website'], FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('The website needs to be a valid url');
        }

        if (! filter_var($data['press-contact'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('The press contact needs to be a valid email address');
        }

        if (array_key_exists('social', $data)) {
            foreach ($data['social'] as $social) {
                if (! (substr($social['link'], 0, 7) == 'callto:') && ! filter_var($social['link'], FILTER_VALIDATE_URL)) { 
                    throw new InvalidArgumentException('The social links need to be a valid urls');
                }
            }
        }

        return $data;
    }
}