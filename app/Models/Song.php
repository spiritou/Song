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
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getAll() 
    {
        $stmt = $this->conn->prepare("SELECT * FROM songs ORDER BY last_update DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }   

    public function delete($id) 
    {
        $stmt = $this->conn->prepare("UPDATE songs SET deleted_songs = 1, last_update = NOW() WHERE id = :id");
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

    public function find($id) 
    {
        $stmt = $this->conn->prepare("SELECT * FROM songs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getChangesSince($since)
    {
        $stmt = $this->conn->prepare("
        SELECT id, name, last_update
        FROM songs
        WHERE last_update > :since
        ORDER BY last_update DESC
        ");
        $stmt->bindParam(':since', $since);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastUpdate()
    {
        $stmt = $this->conn->prepare("
        SELECT MAX(last_update) as latest FROM songs
        ");
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['latest'] ?? null;
    }

    
}