<?php

namespace App\Models;  
use App\Core\Database;

class Song {
    private $id;
    private $name;
    private $conn;

    public function __construct(Database $conn)
    {
        $this->conn = $conn->getConnection();
    }

    public function save($name) 
    {
        $stmt = $this->conn->prepare("INSERT INTO songs (name) VALUES (:name)");
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public function getAll() 
    {
        $stmt = $this->conn->prepare("SELECT * FROM songs ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
       
    }   


    
}