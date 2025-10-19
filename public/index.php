<?php
// Allow CORS for API requests


error_reporting(E_ALL);
ini_set('display_errors',1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

//Use App\Core\Database;
Use App\Core\Router;
use App\Controllers\Songcontroller;
use App\Core\Container;

$container = new Container();
$router = $container->get(Router::class);
$router->get('/', 'Songcontroller@index');
$router->post('/api/songs', 'Songcontroller@store');
$router->get('/api/songs', 'Songcontroller@getAllsongs');
$router->delete('/api/songs/{id}', 'Songcontroller@delete');
$router->put('/api/songs/{id}', 'Songcontroller@update');
$router->get('/api/songs/{id}', 'Songcontroller@show');
// list($controller, $function) = $router->run();
list($callback, $params) = $router->run();
list($controller, $function) = explode('@', $callback);
$controller = "App\\Controllers\\".$controller;
$controllerInstance = $container->get($controller);
//$controllerInstance->$function();

call_user_func_array([$controllerInstance, $function], $params);

