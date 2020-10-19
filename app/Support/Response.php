<?php

namespace App\Support;

class Response
{
    private $content;

    public function __construct($content = null)
    {
        $this->content = $content;
    }

    /**
     * Send the output to the browser
     */
    public function send()
    {
        print $this->content;
    }
}
