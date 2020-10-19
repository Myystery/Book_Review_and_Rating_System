<?php

namespace App\Services;

use App\DataStructure\Collection;
use App\Support\Config;

class SingletonService
{
    /** @var SingletonService */
    private static $instance;
    /** @var Collection */
    private static $ci;

    private function __construct()
    {
        static::$ci = collect();
    }

    /**
     * @return SingletonService
     */
    public static function Instance()
    {
        if ( ! static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Prepare a singleton class in the container
     *
     * @param $class
     *
     * @return mixed
     */
    public function make($class)
    {
        if ( ! static::$ci->has($class)) {
            $obj = new $class;
            static::$ci->set($class, $obj);
        }

        return static::$ci->get($class);
    }

    /**
     * @param $alias
     *
     * @return mixed|null
     */
    public function get($alias)
    {
        /** @var Config $config */
        $config = $this->make(Config::class);

        $aliases = $config->get('alias');

        if ( ! isset($aliases[$alias])) {
            return null;
        }

        return $this->make($aliases[$alias]);
    }
}
