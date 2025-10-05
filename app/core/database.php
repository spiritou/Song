<?php

namespace App\Core;

class Database
{
 private $conn;

 public function __construct()
 {
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    try {
        $this->conn = new \PDO($dsn, DB_USER, DB_PASS);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
 }
 }

 public function getConnection()
 {
    return $this->conn;
 }
}