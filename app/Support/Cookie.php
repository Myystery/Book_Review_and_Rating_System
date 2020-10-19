<?php

namespace App\Support;

class Cookie
{
    /**
     * @param $key
     * @param $value
     * @param $time
     */
    public function set($key, $value, $time)
    {
        setcookie($key, $value, time() + $time, '/', $_SERVER['HTTP_HOST'], false, true);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function get($key)
    {
        return $this->has($key) ? $_COOKIE[$key] : null;
    }

    /**
     * @param $key
     */
    public function forget($key)
    {
        setcookie($key, '', -84005);
    }
}