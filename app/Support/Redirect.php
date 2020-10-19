<?php

namespace App\Support;

class Redirect
{
    private $url;
    private $statusCode = 200;

    public function __construct($url = null)
    {
        $this->url = $url;
    }

    public function __destruct()
    {
        http_response_code($this->statusCode);
        header('location: ' . $this->url);
    }

    public function back()
    {
        $this->url = request()->getReferrer();

        return $this;
    }

    public function withMessage($message)
    {
        Session::set('msg', $message);
        return $this;
    }

    public function with($params)
    {
        foreach ($params as $key => $value) {
            Session::set($key, $value);
        }

        return $this;
    }

    public function withCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    public function route($url)
    {
        $this->url = $url;

        return $this;
    }
}