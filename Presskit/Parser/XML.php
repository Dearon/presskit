<?php

namespace Presskit\Parser;

use \InvalidArgumentException;

class XML
{
    public function parse($xml = '', $type = '')
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

        if (empty($type) == true) {
            throw new InvalidArgumentException('The type argument can not be empty');
        }

        if ($type == 'company') {
            return $this->company($xml);
        } else if ($type == 'project') {
            return $this->project($xml);
        } else {
            throw new InvalidArgumentException('The type argument has to be either company or project');
        }
    }

    private function company($xml)
    {
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
                } else {
                    $array['website'] = (string) '';
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

    public function project($xml = '')
    {
        $data = array();

        // Required
        if (isset($xml->title)) $data['title'] = (string) $xml->title;
        if (isset($xml->{'release-date'})) $data['release-date'] = (string) $xml->{'release-date'};
        if (isset($xml->website)) $data['website'] = (string) $xml->website;
        if (isset($xml->description)) $data['description'] = (string) $xml->description;
        if (isset($xml->history)) $data['history'] = (string) $xml->history;

        // Optional
        if (isset($xml->{'press-can-request-copy'})) $data['press-can-request-copy'] = filter_var($xml->{'press-can-request-copy'}, FILTER_VALIDATE_BOOLEAN);

        if (isset($xml->promoter) && isset($xml->promoter->product)) {
            $data['promoter'] = (string) $xml->promoter->product;
        }

        if (isset($xml->{'monetization-permission'})) {
            $data['monetization-permission'] = array();
            $monetization = strtolower((string) $xml->{'monetization-permission'});

            if ($monetization == 'ask') {
                $data['monetization-permission']['ask'] = true;
            } else if ($monetization == 'non-commercial') {
                $data['monetization-permission']['non-commercial'] = true;
            } else if ($monetization == 'monetize') {
                $data['monetization-permission']['monetize'] = true;
            } else {
                $data['monetization-permission']['not-allowed'] = true;
            }
        }

        if (isset($xml->platforms) && isset($xml->platforms->platform)) {
            $data['platforms'] = array();
            foreach ($xml->platforms->platform as $platform) {
                $data['platforms'][] = array('name' => (string) $platform->name, 'link' => (string) $platform->link);
            }
        }

        if (isset($xml->prices) && isset($xml->prices->price)) {
            $data['prices'] = array();
            foreach ($xml->prices->price as $price) {
                $data['prices'][] = array('currency' => (string) $price->currency, 'value' => (string) $price->value);
            }
        }

        if (isset($xml->features) && isset($xml->features->feature)) {
            $data['features'] = array();
            foreach ($xml->features->feature as $feature) {
                $data['features'][] = (string) $feature;
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
                } else {
                    $array['website'] = '';
                }

                $data['credits'][] = $array;
            }
        }

        return $data;
    }
}

