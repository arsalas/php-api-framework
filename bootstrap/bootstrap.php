<?php

namespace Bootstrap;

use Dotenv\Dotenv;
use Routes\Routes;

class Bootstrap
{

    public static function start()
    {
        $dotenv = Dotenv::createImmutable('../');
        $dotenv->load();
        Routes::start();
    }
}
