<?php

namespace App\Controllers;

use App\Models\Song;

class Songcontroller 
{
    private $songModel;

    public function __construct(Song $songModel)
    {
         $this->songModel = $songModel;
    }

    public function index()
    {
        
        //return $this->songModel->mockfunction();
        require_once __DIR__ . '/../Views/songform.php';
    }
    
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? null;
        if(trim($name) === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Song name is required']);
            return;
        }

        $this->songModel->save($name);
        echo json_encode(['success' => true, 'message' => 'Song added successfully']);
    }

    public function getAllsongs()
    {
        header('Content-Type: application/json');
        $songs = $this->songModel->getAll();
        echo json_encode($songs);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;
        if(!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Song ID is required']);
            return;
        }

        $this->songModel->delete($id);
        echo json_encode(['success' => true, 'message' => 'Song deleted successfully']);
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;
        $name = $data['name'] ?? null;

        if(!$id || trim($name) === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Song ID and name are required']);
            return;
        }

        $this->songModel->update($id, $name);
        echo json_encode(['success' => true, 'message' => 'Song updated successfully']);
    }

    public function show($id) 
    {
        echo "You requested song with ID: " . $id;
    }
}