<?php

namespace Auth\Route;

class Route
{
    private static array $getRoutes = [];
    private static array $postRoutes = [];

    public static function get(string $pattern, $callback): void
    {
        self::$getRoutes[$pattern] = $callback;
    }

    public static function post(string $pattern, $callback): void
    {
        self::$postRoutes[$pattern] = $callback;
    }

    public static function dispatch(string $uri, string $method)
    {
        $routes = $method === 'GET' ? self::$getRoutes : self::$postRoutes;
        foreach ($routes as $pattern => $callback) {
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($callback, $matches);
            }
        }

        // Можно было сделать какой-нибудь обработчик для ошибок
    }
}