<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function delete($path, $callback)
    {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = str_replace('/Song/public', '', $path); // Adjust base path as needed
        $callback = $this->routes[$method][$path] ?? null;

        if(isset($callback))
        {
            // echo "this is callback";
            return explode('@', $callback);
            /*$controller = "App\\Controllers\\".$controller;
            $controllerInstance = new $controller();
            // $controllerInstance->$function();
            // var_dump($controllerInstance);
            $controllerInstance->$function();*/
        }
        else
        {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}