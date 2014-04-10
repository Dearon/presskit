<?php

$invalidCreditWebsiteArray = array(
    // Required
    'title' => 'Company Name',
    'founding-date' => 'September 1, 2010',
    'website' => 'http://www.website.com/',
    'based-in' => 'Cityville, Metropolisland',
    'press-contact' => 'press-contact@company.com',
    'phone' => '+00 (1) 22 33 44 55 66',
    'description' => 'We\'re games studio and we make games. We\'re also capable of editing XML files.',

    // Optional
    'credits' => array(
        array(
            'person' => 'Valid',
            'role' => 'Valid',
            'website' => 'http://www.test.com',
        ),
        array(
            'person' => 'Invalid',
            'role' => 'Invalid',
            'website' => 'www.test',
        ),
    ),
);

