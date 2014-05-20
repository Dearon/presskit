<?php

namespace Presskit;

use \InvalidArgumentException;

class Email
{
    private $test;

    public function __construct($test = false)
    {
        $this->test = (bool) $test;
    }

    public function email($to = '', $from = '', $outlet = '', $gametitle = '')
    {
        $outlet = htmlentities($outlet);
        $gametitle = htmlentities($gametitle);

        if (! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('The to email address needs to be a valid email address');
        }

        if (! filter_var($from, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('The from email address needs to be a valid email address');
        }

        if (empty($outlet)) {
            throw new InvalidArgumentException('The outlet field can not be empty');
        }

        if (empty($gametitle)) {
            throw new InvalidArgumentException('The gametitle field can not be empty');
        }

        $subject = '[Request] ' . $gametitle . ' Press Copy For ' . $outlet;
        $message = wordwrap($from . ' of ' . $outlet . ' has requested a Press Copy for ' . $gametitle . ' through the press kit interface.', 70, "\r\n");

        $headers  = 'From: ' . $from . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        return (bool) $this->send($to, $subject, $message, $headers);
    }

    private function send($to, $subject, $message, $headers)
    {
        if ($this->test) {
            return true;
        } else {
            return mail($to, $subject, $message, $headers);
        }
    }
}

    


