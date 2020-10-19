<?php

namespace App\Support;

use App\DataStructure\Collection;
use App\DataStructure\FileBag;

class Request
{
    /** @var Collection */
    private static $get;
    /** @var Collection */
    private static $post;
    /** @var Collection */
    private static $files;
    /** @var Collection */
    private static $info;

    public function __construct()
    {
        static::$get   = collect($_GET);
        static::$post  = collect($_POST);
        static::$files = collect($_FILES)
            ->filter(function ($file) {
                return $file['error'] === 0;
            })
            ->map(function ($file) {
                return new FileBag($file);
            });
        static::$info  = $_SERVER;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return static::$get
            ->merge(static::$post->toArray(), true)
            ->merge(static::$files->toArray(), true);
    }

    /**
     * Determine if requests has a key
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return static::$get->has($key)
               || static::$post->has($key)
               || static::$files->has($key);
    }

    /**
     * Determine if request has a file
     *
     * @param $key
     *
     * @return bool
     */
    public function hasFile($key)
    {
        return static::$files->has($key);
    }

    /**
     * Get input
     *
     * @param $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function input($key, $default = null)
    {
        if (static::$get->has($key)) {
            return static::$get->get($key);
        } elseif (static::$post->has($key)) {
            return static::$post->get($key);
        } elseif (static::$files->has($key)) {
            return static::$files->get($key);
        }

        return $default;
    }

    /**
     * @param $key
     * @param $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->input($key, $default);
    }

    /**
     * @param $key
     *
     * @return FileBag|null
     */
    public function file($key)
    {
        if ($this->hasFile($key)) {
            return static::$files->get($key);
        }

        return null;
    }

    public function only($keys)
    {
        return $this->all()->only($keys);
    }

    /**
     * @return mixed
     */
    public function requestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return mixed
     */
    public function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return mixed
     */
    public function getReferrer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['HTTP_HOST'];
    }
}
