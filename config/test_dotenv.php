<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

if (class_exists('Dotenv\Dotenv')) {
    echo "Dotenv is installed and autoloaded successfully.\n";
} else {
    echo "Dotenv is NOT installed or autoloaded.\n";
}