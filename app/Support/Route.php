<?php

namespace App\Support;

class Route
{
    private static $get = [];
    private static $post = [];

    /**
     * Add a GET route
     *
     * @param $path
     * @param $callable
     */
    public static function get($path, $callable)
    {
        if (array_key_exists($path, static::$get)) {
            die("Similar route detected for similar method GET -> {$path}");
        }
        static::$get[$path] = static::getParts($callable);
    }

    /**
     * Add a POST route
     *
     * @param $path
     * @param $callable
     */
    public static function post($path, $callable)
    {
        if (array_key_exists($path, static::$post)) {
            die("Similar route detected for similar method POST -> {$path}");
        }
        static::$post[$path] = static::getParts($callable);
    }

    /**
     * Get parts of callable
     *
     * @param $callable
     *
     * @return array
     */
    private static function getParts($callable)
    {

        $callable_parts = explode('@', $callable);
        $controller     = 'App\\Http\\Controllers\\' . $callable_parts[0];

        return [
            'controller' => $controller,
            'method'     => $callable_parts[1]
        ];
    }

    /**
     * Get route information
     *
     * @param $method
     * @param $route
     *
     * @return mixed|null
     */
    public static function getRouteInfo($method, $route)
    {
        $list = null;
        switch ($method) {
            case 'GET':
                $list = static::$get;
                break;
            case 'POST':
                $list = static::$post;
                break;
            default:
        }
        if ( ! $list) {
            return null;
        }

        $keys = array_keys($list);

        $args = [];

        $callable = null;

        foreach ($keys as $key) {
            $regex = preg_replace('/{(.*?)}/', '(?P<$1>[0-9]+)', $key);
            preg_match('#^' . $regex . '(\?.*)?$#Uis', $route, $matched_args);
            if (count($matched_args)) {
                preg_match_all('/{(.*)}/Uis', $key, $matches);
                if (count($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $model_class = config('models.' . $match);
                        if ( ! $model_class) {
                            die("Unknown model {$match}");
                        }
                        $model = $model_class::find(['id' => $matched_args[$match]]);
                        if ( ! $model) {
                            die(ucfirst($match) . ' with ID ' . $matched_args[$match] . ' does not exist;');
                        }
                        $args[$match] = $model;
                    }
                }
                $callable         = $list[$key];
                $callable['args'] = $args;
                break;
            }
        }

        return $callable;
    }
}
