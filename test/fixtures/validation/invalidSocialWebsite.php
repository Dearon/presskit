<?php

$invalidSocialWebsiteArray = array(
    // Required
    'title' => 'Company Name',
    'founding-date' => 'September 1, 2010',
    'website' => 'http://www.website.com',
    'based-in' => 'Cityville, Metropolisland',
    'press-contact' => 'press-contact@company.com',
    'phone' => '+00 (1) 22 33 44 55 66',
    'description' => 'We\'re games studio and we make games. We\'re also capable of editing XML files.',

    // Optional
    'social' => array(
        array(
            'name' => 'Valid',
            'link' => 'http://www.test.com',
        ),
        array(
            'name' => 'callto is also valid',
            'link' => 'callto:test',
        ),
        array(
            'name' => 'Invalid',
            'link' => 'www.test',
        ),
    ),
);

