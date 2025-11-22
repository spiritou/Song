<?php

namespace App\Controllers;
use App\Models\User;

class Authenticationcontroller 
{
    private $usermodel;
    public function __construct(User $usermodel)
    {
       $this->usermodel = $usermodel;
    }
    public function index()
    {
        require_once __DIR__ . '/../Views/loginform.php';
    }

    public function login()
    {
        // Handle login logic here
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if(!$data || empty($data['name']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Name and password are required']);
            return;
        }

        $user = $this->usermodel->findByUsername($data['name']);
        if(!$user || !password_verify($data['password'], $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid name or password']);
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        echo json_encode(['success' => true]);
    }
}