<?php

use Illuminate\Support\Facades\Route;


if (!function_exists('deletePublicPathFiles')) {
    function deletePublicPathFiles($path){
        // Delete the image file from the public/uploads directory
        if (file_exists($path)) {
            unlink($path);
        }
    }
}

if (!function_exists('public_asset')) {
    function public_asset($path = ''){
        // dd(url($path));
        return url('public/'.$path);
    }
}

function isActiveRoute($route, $output = 'active')
{
    if (is_array($route)) {
        if (in_array(Route::currentRouteName(), $route)) {
            return $output;
        }
    } else {
        if (Route::currentRouteName() == $route) {
            return $output;
        }
    }
}


if (!function_exists('printArray')) {
    function printArray()
    {
        $params = func_get_args();

        echo "<pre>";
        foreach ($params as $p) {
            print_r($p);
        }
        echo "</pre>";
        die;
    }
}

if (!function_exists('returnWebResponse')) {
    function returnWebResponse($status = 'error', $message = null, $data = null)
    {
        return array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
    }
}

?>
