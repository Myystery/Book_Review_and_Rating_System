<?php

namespace App\Support;

use App\DataStructure\Collection;

class Session
{
    /** @var Collection */
    private static $session;

    public static function forget($key)
    {
        static::$session->remove($key);
        unset($_SESSION[$key]);
    }

    public static function flash(string $key)
    {
        $value = self::get($key);
        self::forget($key);

        return $value;
    }

    public function boot()
    {
        session_start();

        static::$session = collect($_SESSION);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public static function has($key)
    {
        return static::$session->has($key);
    }

    public static function get($key, $default = null)
    {
        $value = static::$session->get($key);
        if ( ! $value) {
            return $default;
        }

        return $value;
    }

    public static function set($key, $value)
    {
        static::$session->set($key, $value);
        $_SESSION[$key] = $value;
    }
}