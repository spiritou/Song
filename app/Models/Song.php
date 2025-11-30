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

    public function save($user_id,$name) 
    {
        $stmt = $this->conn->prepare("INSERT INTO songs (name, users_id) VALUES (:name, :users_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':users_id', $user_id);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getAllSongsbyID($user_id) 
    {
        $stmt = $this->conn->prepare("SELECT * FROM songs WHERE deleted_songs = 0 AND users_id :user_id ORDER BY last_update DESC");
        $stmt->bindParam(':user_id', $user_id);
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
        $stmt = $this->conn->prepare("UPDATE songs SET name = :name, last_update = NOW() WHERE id = :id");
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
        SELECT id, name, last_update, deleted_songs
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