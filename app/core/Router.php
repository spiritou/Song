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

    public function put($path, $callback)
    {
        $this->routes['PUT'][$path] = $callback;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = str_replace('/Song/public', '', $path); // Adjust base path as needed
        //$callback = $this->routes[$method][$path] ?? null;

        if(!isset($this->routes[$method]))
        {
            // echo "this is callback";
            //return explode('@', $callback);
            /*$controller = "App\\Controllers\\".$controller;
            $controllerInstance = new $controller();
            // $controllerInstance->$function();
            // var_dump($controllerInstance);
            $controllerInstance->function();*/
            http_response_code(404);
            echo "404 Not Found";
            return;
        }
        // else
        // {
        //     http_response_code(404);
        //     echo "404 Not Found";
        // }

        foreach ($this->routes[$method] as $route=>$callback) {
            $pattern = preg_replace('#\{([^\}]+)\}#', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove the full match

                return [$callback, $matches];
        }
    }
        http_response_code(404);
        echo "404 Not Found";
    }
}