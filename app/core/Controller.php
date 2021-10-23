<?php

namespace App\Core;

use App\Helpers\headers;

class Controller
{
    public $request;
    public $files;
    public $headers;
    public $token;
    public $middlewares;

    public function __construct($middlewares, $request = null)
    {
        $this->request = $request;
        $this->headers = headers::get();
        $this->token = headers::token();
        $this->middlewares = $middlewares;
    }
}
