<?php
// Allow CORS for API requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors',1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

//Use App\Core\Database;
Use App\Core\Router;
use App\Controllers\Songcontroller;
use App\Core\Container;

/*$pdo = new Database();
  $conn = $pdo->getConnection();

  var_dump($conn);

$router = new Router();
$router->get('/', 'Songcontroller@index');
$router->run();*/

$container = new Container();
$router = $container->get(Router::class);
$router->get('/', 'Songcontroller@index');
$router->post('/api/songs', 'Songcontroller@store');
// $router->run();
list($controller, $function) = $router->run();
$controller = "App\\Controllers\\".$controller;
$controllerInstance = $container->get($controller);
$controllerInstance->$function();

