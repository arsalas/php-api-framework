<?php

namespace App\Helpers;

use Rakit\Validation\Validator as ValidatorLib;

class validator
{
    public static function validate($data, $rules)
    {
        $validator = new ValidatorLib();
        $validation = $validator->make($data, $rules);

        $validation->validate();
        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            $errors = $errors->firstOfAll();

            $response = array(
                'status' => 'KO',
                'code'  => 400,
                'validation' => $errors
            );

            response::json($response);
        }
    }
}
