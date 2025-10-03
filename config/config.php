<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('BASE_PATH', __DIR__ . '/../');
define('PUBLIC_PATH', BASE_PATH . 'public/');
define('APP_PATH', BASE_PATH . 'app/');
define('CONTROLLER_PATH', APP_PATH . 'Controllers/');
define('MODEL_PATH', APP_PATH . 'Models/');
define('VIEW_PATH', APP_PATH . 'Views/');

define('APP_URL', $_ENV['APP_URL']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);


