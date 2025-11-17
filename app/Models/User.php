<?php 

namespace App\Models;

use App\Core\Database;

class User {
    private $conn;

    public function __construct(Database $conn)
    {
        $this->conn = $conn->getConnection();
    }

    public function create($username, $password, $role='user') 
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (name, password, role) VALUES (:name, :password, :role)");

        return $stmt->execute([
            ':name' => $username,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
    }

    public function findByUsername($username)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM users WHERE name = :name LIMIT 1
        ");
        $stmt->execute([':name' => $username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
        
}