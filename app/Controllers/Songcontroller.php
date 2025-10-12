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
}