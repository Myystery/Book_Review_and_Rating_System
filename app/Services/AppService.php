<?php

namespace App\Services;

use App\Exceptions\ViewNotFoundException;
use App\Support\Session;
use App\Support\View;

class AppService
{
    /**
     * Run the app
     * @throws ViewNotFoundException
     */
    public function run()
    {
        (new Session())->boot();

        /** @var RoutingService $routingService */
        $routingService = app()->make(RoutingService::class);

        View::addParam('title', config('app.name'));
        View::setMasterLayout(view(config('layout.master')));

        $view = $routingService->run();

        if (method_exists($view, 'render')) {
            $view->render();
        }
    }
}
