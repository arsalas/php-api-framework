<?php

namespace App\Helpers;

class Utils
{

    public static function encryptPassword($password)
    {
        return hash('sha256', $password);
    }

    public static function getImage($path, $filename)
    {
        $img = file_get_contents((dirname(__FILE__, 3) . "/storage/images/{$path}/{$filename}"));
        header('Content-Type: image/jpeg');
        echo $img;
        die();
    }

    public static function arrayToObject($array)
    {
        return json_decode(json_encode($array));
    }


    public static function renderView($filename)
    {
        include((dirname(__FILE__, 3) . '/views/' . $filename . '.php'));

        die();
    }

    public static function deleteDir($dir)
    {
        $count = 0;

        // ensure that $dir ends with a slash so that we can concatenate it with the filenames directly
        $dir = rtrim($dir, "/\\") . "/";

        // use dir() to list files
        $list = dir($dir);

        // store the next file name to $file. if $file is false, that's all -- end the loop.
        while (($file = $list->read()) !== false) {
            if ($file === "." || $file === "..") continue;
            if (is_file($dir . $file)) {
                unlink($dir . $file);
                $count++;
            } elseif (is_dir($dir . $file)) {
                $count += self::deleteDir($dir . $file);
            }
        }

        // finally, safe to delete directory!
        // rmdir($dir);

        return $count;
    }
}
