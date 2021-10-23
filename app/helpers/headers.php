<?php

namespace App\Helpers;

use Waavi\Sanitizer\Sanitizer;

class headers

{

    public static function get()
    {

        $headers = apache_request_headers();

        return $headers;
    }

    public static function token()
    {

        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $sanitizer  = new Sanitizer(array('Authorization' => $headers['Authorization']), array('Authorization' => 'trim|escape'));
            $response = $sanitizer->sanitize();
            $response = $response['Authorization'];
        } else {
            $response = null;
        }
        return  $response;
    }
}
