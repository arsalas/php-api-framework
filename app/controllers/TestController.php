<?php

namespace App\Controllers;

use App\Core\Controller;

class TestController extends Controller
{
    public function __construct($middlewares, $request = null)
    {
        parent::__construct($middlewares, $request);
    }

    public function main()
    {
        $response = array(200, 'api framework');

        return $response;
    }
}
