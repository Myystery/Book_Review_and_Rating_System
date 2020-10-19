<?php

namespace App\Services;

use App\Support\Request;
use App\Support\Route;

class RoutingService
{
    public function __construct()
    {
        $routeFile = base_dir('app/Http') . 'routes.php';
        if ( ! file_exists($routeFile)) {
            throw new \Exception("Route file not found: {$routeFile}");
        }
        include $routeFile;
    }

    /**
     * @return \App\Support\View
     * @throws \App\Exceptions\ViewNotFoundException
     */
    public function run()
    {
        /** @var Request $request */
        $request = app('request');

        $uri    = $request->requestUri();
        $method = $request->requestMethod();

        $callable = Route::getRouteInfo($method, $uri);

        if ($callable) {
            $instance = new $callable['controller'];

            return call_user_func_array([$instance, $callable['method']], $callable['args']);
        }

        return view('error.404');
    }
}
