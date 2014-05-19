<?php

$projectFullArray = array(
    // Required
    'title' => 'Game Name',
    'release-date' => '1 May, 2012',
    'website' => 'http://www.gamesite.com/',
    'description' => 'Hello. This is a short compilation of facts about the game. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    'history' => 'Since we\'re an indie developer, we want a history to our game. This paragraph will explain this history in short. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',

    // Optional
    'press-can-request-copy' => True,
    'monetization-permission' => array(
        'monetize' => true,
    ),
    'platforms' => array(
        array(
            'name' => 'PC / Mac',
            'link' => 'http://www.gamesite.com/'
        ),
        array(
            'name' => 'Steam',
            'link' => 'http://www.steampowered.com/'
        ),
        array(
            'name' => 'Apple App Store',
            'link' => 'http://www.itunes.com/'
        ),
    ),
    'prices' => array(
        array(
            'currency' => 'USD',
            'value' => '$1.99',
        ),
        array(
            'currency' => 'EUR',
            'value' => '€1.59',
        ),
        array(
            'currency' => 'CAD',
            'value' => '$1.99',
        ),
        array(
            'currency' => 'GBP',
            'value' => '£1.29',
        ),
    ),    
    'features' => array(
        'Includes something really interesting about the game which players will love.',
        'This feature line is about the 8-bit pixels that are no doubt featuring in this game.',
        'Since it is unlikely that the audio isn\'t fucking amazing, say something about the audio, maybe?',
        'Make sure to stress that everything about this game is absolutely fabulous.',
        'Something to wrap up this 5-point feature list with a nice ring to it.',
    ),
    'trailers' => array(
        array(
            'name' => 'Trailer',
            'type' => 'youtube',
            'id' => '7jQbITg0MSk',
        ),
        array(
            'name' => 'Gameplay Video',
            'type' => 'vimeo',
            'id' => '23571681',
        ),
    ),
    'awards' => array(
        array(
            'description' => 'Winner in this highly relevant contest.',
            'info' => 'Award Location, 20 October, 1989',
        ),
        array(
            'description' => 'Nomination for this prestigious award.',
            'info' => 'Award Ceremony, 4 December, 1991',
        ),
        array(
            'description' => 'Winner in this highly relevant contest.',
            'info' => 'Award Location, 20 October, 1989',
        ),
        array(
            'description' => 'Nomination for this prestigious award.',
            'info' => 'Award Ceremony, 4 December, 1991',
        ),
    ),
    'quotes' => array(
        array(
            'description' => 'This is a rather insignificant quote by a highly important person.',
            'name' => 'Person Name',
            'website' => 'Website',
            'link' => 'http://www.website.com/',
        ),
        array(
            'description' => 'An extremely positive quote from a rather insignificant person. Also great.',
            'name' => 'Some Guy',
            'website' => 'This Page Is Visited By 12 Visitors A Month',
            'link' => 'http://geocities.blog.com/',
        ),
        array(
            'description' => 'I pretend to love this game even though I do not actually understand it.',
            'name' => 'Pretentious Bastard',
            'website' => 'Artsy Page',
            'link' => 'http://art.tumblr.com/',
        ),
        array(
            'description' => 'HOLY SHIT SO AMAZING',
            'name' => 'Caps Guy',
            'website' => 'Angry Review',
            'link' => 'http://thispage.net/angrytube',
        ),
    ),
    'additionals' => array(
        array(
            'title' => 'Original Soundtrack',
            'description' => 'Available for free from',
            'link' => 'http://somemusicsite.com/thislink',
        ),
        array(
            'title' => 'Release Blog Post',
            'description' => 'The blog-post through which this game was released is available at',
            'link' => 'http://vlambeer.com/bloglink',
        ),
    ),
    'credits' => array(
        array(
            'person' => 'Rami Ismail',
            'role' => 'Business & Development, Vlambeer',
            'website' => '',
        ),
        array(
            'person' => 'Jan Willem Nijman',
            'role' => 'Game Designer, Vlambeer',
            'website' => '',
        ),
        array(
            'person' => 'John Doe',
            'role' => 'Artist, Freelancer',
            'website' => '',
        ),
        array(
            'person' => 'Oliver Twist',
            'role' => 'Artist, Freelancer',
            'website' => 'http://www.olivertwist.com',
        ),
        array(
            'person' => 'Jane Doette',
            'role' => 'Music, Freelancer',
            'website' => 'http://www.olivertwist.com',
        ),
    ),
);
