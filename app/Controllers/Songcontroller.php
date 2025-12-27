<?php
/* The store function will have to be refactored in order to return the whole newly added song */

namespace App\Controllers;

use App\Models\Song;
use App\core\Auth;

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
        header('Content-Type: application/json');

        if(!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? null;
        if(trim($name) === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Song name is required']);
            return;
        }
        $user_id = $_SESSION['user_id'];

        $id = $this->songModel->save($user_id,$name);

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
        Auth::requireLogin();

        $role = $_SESSION['user_role'];
        $user_id = $_SESSION['user_id'];
        
        if ($role === 'admin') {
            $songs = $this->songModel->AdminGetAllSongs();
        } else {
            $songs = $this->songModel->getAllSongsbyID($user_id);
        }

        //$last_update = null;
        if (empty($songs)) {
            $last_update = date('Y-m-d H:i:s');
        } else {
            $last_update = $songs[0]['last_update'];
        }

        echo json_encode([
            'songs' => $songs, 
            'last_update' => $last_update
        ]);

    }

    public function delete($id)
    {
        Auth::requireRole('user');
        header('Content-Type: application/json');
        $user_id = $_SESSION['user_id'];

        // if(!isset($_SESSION['user_id'])) {
        //     http_response_code(401);
        //     echo json_encode(['error' => 'Unauthorized']);
        //     return;
        // }

          if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        
        $success = $this->songModel->delete($id, $user_id);
        echo json_encode(['success' => $success]);
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        if(!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        // Release session lock early since we don't need to modify session data
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        $user_id = $_SESSION['user_id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $success = $this->songModel->update($id, $data['name'], $user_id);
        echo json_encode(['success' => $success]);
    }

    public function show($id) 
    {
        echo "You requested song with ID: " . $id;
    }

    public function getChanges()
    {
        header('Content-Type: application/json');
        
        // Release session lock early to prevent blocking other requests
        // This is critical for long polling endpoints
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        // if(!isset($_GET['since']))
        // {
        //     echo json_encode(['error' => 'Missing "since" parameter']);
        //     return;
        // }

        // $since = $_GET['since'];
        $user_id = $_SESSION['user_id'];
        $since = $_GET['since'] ?? null;
        if (!$since) {
            echo json_encode(['error' => 'Missing "since" parameter']);
            return;
        }

        $startTime = time();
        $timeout = 30; // seconds

        do {
            
             $changes = $this->songModel->getChangesSince($since, $user_id);

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
