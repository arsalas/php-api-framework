<?php

namespace App\Helpers;


class response
{

    public static function json($code, $response)
    {
        header("HTTP/1.1 {$code}");
        echo json_encode($response);
        exit();
    }
}
