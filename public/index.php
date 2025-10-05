<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

Use App\Core\Database;

$pdo = new Database();
$conn = $pdo->getConnection();

var_dump($conn);