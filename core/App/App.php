<?php

namespace Auth\App;

use Auth\Route\Route;

class App
{
    public static function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        Route::dispatch($uri, $method);
    }
}