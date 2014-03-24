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

        return $data;
    }
}
