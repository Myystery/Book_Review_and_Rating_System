<?php

namespace App\Support;

class Config
{
    private $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $config = [];
        $files  = glob(__DIR__ . '/../../config/*.php');

        foreach ($files as $file) {
            $config[strtolower(basename($file, '.php'))] = include $file;
        }

        $this->config = collect($config);
    }

    /**
     *
     * @param $path
     *
     * @return mixed|null
     */
    public function get($path)
    {
        $value = $this->config->toArray();
        if ( ! $path) {
            return $value;
        }

        $_path = explode('.', $path);
        foreach ($_path as $item) {
            if (isset($value[$item])) {
                $value = $value[$item];
            } else {
                return null;
            }
        }

        return $value;
    }
}