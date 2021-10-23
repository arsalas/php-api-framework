<?php

namespace App\Middlewares;

use App\Helpers\headers;
use App\Helpers\response;
use App\Messages\Messages;
use App\Models\User;

class Test
{
    private $request;
    private $middlewares;

    public function __construct($request = null, $middlewares = null)
    {
        $this->request = $request;
        $this->middlewares = $middlewares;
    }

    public function handle()
    {
        $identity = true;
        if (!$identity) {
            response::json(401, 'Not authorized');
        } else {

            return $identity;
        }
    }
}
