<?php
/* The store function will have to be refactored in order to return the whole newly added song */

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

        $id = $this->songModel->save($name);

        $song = $this->songModel->find($id);

        echo json_encode([
            'success' => true, 
            'message' => 'Song added successfully',
            'song' => $song
        ]);
    }

    public function getAllsongs()
    {
        header('Content-Type: application/json');
        $songs = $this->songModel->getAll();

        $last_update = null;
        if (!empty($songs)) {
            $last_update = $songs[0]['last_update'];
        }

        echo json_encode([
            'songs' => $songs, 
            'last_update' => $last_update
        ]);
    }

    public function delete($id)
    {
        $success = $this->songModel->delete($id);
        echo json_encode(['success' => $success]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $success = $this->songModel->update($id, $data['name']);
        echo json_encode(['success' => $success]);
    }

    public function show($id) 
    {
        echo "You requested song with ID: " . $id;
    }

    public function getChanges()
    {
        header('Content-Type: application/json');
        
        // if(!isset($_GET['since']))
        // {
        //     echo json_encode(['error' => 'Missing "since" parameter']);
        //     return;
        // }

        // $since = $_GET['since'];

        $since = $_GET['since'] ?? null;
        if (!$since) {
            echo json_encode(['error' => 'Missing "since" parameter']);
            return;
        }

        $startTime = time();
        $timeout = 30; // seconds

        do {
             $changes = $this->songModel->getChangesSince($since);

             if (!empty($changes)) {
                echo json_encode([
                    'changes' => $changes,
                    'last_update' => $changes[0]['last_update']
                ]);
                return;
             }
             usleep(500000); // Sleep for 0.5 seconds
        } while (time() - $startTime < $timeout);

        echo json_encode(['changes' => []]);
       

        // $last_update = $this->songModel->getLastUpdate();

        // echo json_encode([
        //     'changes' => $changes,
        //     'last_update' => $last_update
        // ]);

    }
}
