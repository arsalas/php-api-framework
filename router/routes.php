<?php

namespace Routes;

use App\Core\Router;

class Routes
{
    public static function start()
    {
        $router = new Router;

        /*
        |--------------------------------------------------------------------------
        | Create a new route
        |--------------------------------------------------------------------------
        | 
        | method(path, Controller@function, [middlewares])
        |
        */

        $router->get('test', 'TestController@main',['test']);



        // INICIAR ROUTER
        $router->start();
    }
}
