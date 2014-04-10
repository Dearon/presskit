<?php

namespace Presskit\Parser;

use \InvalidArgumentException;

class XML
{
    public function parse($xml = '')
    {
        if (empty($xml) === true) {
            throw new InvalidArgumentException('The XML argument can not be empty');
        }

        if (file_exists($xml) === false) {
            throw new InvalidArgumentException('The XML argument has to be a file');
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($xml);
        $errors = libxml_get_errors();
        libxml_use_internal_errors(false);

        if (count($errors) > 0) {
            throw new InvalidArgumentException('The XML argument has to be valid XML');
        }

        $data = array();

        // Required
        if (isset($xml->title)) $data['title'] = (string) $xml->title;
        if (isset($xml->{'founding-date'})) $data['founding-date'] = (string) $xml->{'founding-date'};
        if (isset($xml->website)) $data['website'] = (string) $xml->website;
        if (isset($xml->{'based-in'})) $data['based-in'] = (string) $xml->{'based-in'};
        if (isset($xml->{'press-contact'})) $data['press-contact'] = (string) $xml->{'press-contact'};
        if (isset($xml->phone)) $data['phone'] = (string) $xml->phone;
        if (isset($xml->description)) $data['description'] = (string) $xml->description;

        // Optional
        if (isset($xml->analytics)) $data['analytics'] = (string) $xml->analytics;

        if (isset($xml->address) && isset($xml->address->line)) {
            $data['address'] = array();
            foreach ($xml->address->line as $line) {
                $data['address'][] = (string) $line;
            }
        }

        if (isset($xml->socials) && isset($xml->socials->social)) {
            $data['social'] = array();
            foreach ($xml->socials->social as $social) {
                $data['social'][] = array('name' => (string) $social->name, 'link' => (string) $social->link);
            }
        }
        
        if (isset($xml->histories) && isset($xml->histories->history)) {
            $data['history'] = array();
            foreach ($xml->histories->history as $history) {
                $data['history'][] = array('name' => (string) $history->header, 'text' => (string) $history->text);
            }
        }

        if (isset($xml->trailers) && isset($xml->trailers->trailer)) {
            $data['trailers'] = array();
            foreach ($xml->trailers->trailer as $trailer) {
                $array = array('name' => (string) $trailer->name);

                if (isset($trailer->youtube)) {
                    $array['type'] = 'youtube';
                    $array['id'] = (string) $trailer->youtube;
                }

                if (isset($trailer->vimeo)) {
                    $array['type'] = 'vimeo';
                    $array['id'] = (string) $trailer->vimeo;
                }

                $data['trailers'][] = $array;
            }
        }

        if (isset($xml->awards) && isset($xml->awards->award)) {
            $data['awards'] = array();
            foreach ($xml->awards->award as $award) {
                $data['awards'][] = array('description' => (string) $award->description, 'info' => (string) $award->info);
            }
        }

        if (isset($xml->quotes) && isset($xml->quotes->quote)) {
            $data['quotes'] = array();
            foreach ($xml->quotes->quote as $quote) {
                $data['quotes'][] = array('description' => (string) $quote->description, 'name' => (string) $quote->name, 'website' => (string) $quote->website, 'link' => (string) $quote->link);
            }
        } 

        if (isset($xml->additionals) && isset($xml->additionals->additional)) {
            $data['additionals'] = array();
            foreach ($xml->additionals->additional as $additional) {
                $data['additionals'][] = array('title' => (string) $additional->title, 'description' => (string) $additional->description, 'link' => (string) $additional->link);
            }
        }

        if (isset($xml->credits) && isset($xml->credits->credit)) {
            $data['credits'] = array();
            foreach ($xml->credits->credit as $credit) {
                $array = array('person' => (string) $credit->person, 'role' => (string) $credit->role);

                if (isset($credit->website)) {
                    $array['website'] = (string) $credit->website;
                }

                $data['credits'][] = $array;
            }
        }

        if (isset($xml->contacts) && isset($xml->contacts->contact)) {
            $data['contact'] = array();
            foreach($xml->contacts->contact as $contact) {
                $array = array('name' => (string) $contact->name);

                if (isset($contact->mail)) {
                    $array['mail'] = (string) $contact->mail;
                }

                if (isset($contact->link)) {
                    $array['link'] = (string) $contact->link;
                }

                $data['contact'][] = $array;
            }
        }

        return $data;
    }
}
