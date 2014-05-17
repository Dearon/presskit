<?php

namespace Presskit;

use \InvalidArgumentException;

class Validation
{
    public function validate($data = array(), $type = '')
    {
        if (! is_array($data)) {
            throw new InvalidArgumentException('The data array must be an array');
        }

        if (empty($data)) {
            throw new InvalidArgumentException('The data array can not be empty');
        }

        if ($type == 'company') {
            return $this->company($data);
        } else if ($type == 'project') {
            return $this->project($data);
        } else {
            throw new InvalidArgumentException('The type argument has to be either company or project');
        }
    }

    private function company($data)
    {
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
                    throw new InvalidArgumentException('The social links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('quotes', $data)) {
            foreach ($data['quotes'] as $quote) {
                if (! filter_var($quote['link'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The quote links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('additionals', $data)) {
            foreach ($data['additionals'] as $additional) {
                if (! filter_var($additional['link'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The additional links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('credits', $data)) {
            foreach($data['credits'] as $credit) {
                if (! empty($credit['website']) && ! filter_var($credit['website'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The credit links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('contact', $data)) {
            foreach($data['contact'] as $contact) {
                if (array_key_exists('link', $contact) && ! filter_var($contact['link'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The contact links needs to be a valid urls');
                }
                if (array_key_exists('mail', $contact) && ! filter_var($contact['mail'], FILTER_VALIDATE_EMAIL)) {
                    throw new InvalidArgumentException('The contact mail needs to be a valid email address');
                }
            }
        }

        return $data;
    }

    private function project($data)
    {
        $invalid = false;

        if (! array_key_exists('title', $data)) $invalid = true;
        if (! array_key_exists('release-date', $data)) $invalid = true;
        if (! array_key_exists('website', $data)) $invalid = true;
        if (! array_key_exists('description', $data)) $invalid = true;
        if (! array_key_exists('history', $data)) $invalid = true;

        if ($invalid) {
            throw new InvalidArgumentException('The data array did not contain all the necessary fields');
        }

        if (array_key_exists('website', $data)) {
            if (! filter_var($data['website'], FILTER_VALIDATE_URL)) {
                throw new InvalidArgumentException('The website needs to be a valid url');
            }
        }

        if (array_key_exists('platforms', $data)) {
            foreach ($data['platforms'] as $platform) {
                if (! filter_var($platform['link'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The platform links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('quotes', $data)) {
            foreach ($data['quotes'] as $quote) {
                if (! filter_var($quote['link'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The quote links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('additionals', $data)) {
            foreach ($data['additionals'] as $additional) {
                if (! filter_var($additional['link'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The additional links needs to be a valid urls');
                }
            }
        }

        if (array_key_exists('credits', $data)) {
            foreach($data['credits'] as $credit) {
                if (! empty($credit['website']) && ! filter_var($credit['website'], FILTER_VALIDATE_URL)) {
                    throw new InvalidArgumentException('The credit links needs to be a valid urls');
                }
            }
        }

        return $data;
    }
}
