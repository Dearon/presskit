<?php

namespace Presskit;

use \InvalidArgumentException;

class Promoter
{
    public function promoter($promotercode = '') {
        if (empty($promotercode)) {
            throw new InvalidArgumentException('The promoter code can not be empty');
        }

        $url = 'http://www.promoterapp.com/dopresskit/' . (int) $promotercode;
        $headers = get_headers($url);

        if (strpos($headers[0], '200 OK') === false) {
            throw new InvalidArgumentException('The promoter app has no data for that code');
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($url);
        $errors = libxml_get_errors();
        libxml_use_internal_errors(false);

        if (count($errors) > 0) {
            throw new InvalidArgumentException('The promoter XML file is not valid XML');
        }

        $data = array();

        if (isset($xml->reviews)) {
            $data['quotes'] = array();
            foreach($xml->reviews->review as $quote) {
                $data['quotes'][] = array('description' => (string) $quote->quote, 'name' => (string) $quote->{'reviewer-name'}, 'website' => (string) $quote->{'publication-name'}, 'link' => (string) $quote->url);
            }
        }

        if (isset($xml->awards)) {
            $data['awards'] = array();
            foreach($xml->awards->award as $award) {
                $data['awards'][] = array('description' => (string) $award->title, 'info' => (string) $award->location);
            }
        }
        
        return $data;
    }
}
