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

    public function delete($id) 
    {
        $stmt = $this->conn->prepare("DELETE FROM songs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update($id, $name) 
    {
        $stmt = $this->conn->prepare("UPDATE songs SET name = :name WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    
}