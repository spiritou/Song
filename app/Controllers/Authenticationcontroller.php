<?php

namespace App\Controllers;
use App\Models\User;

class Authenticationcontroller 
{
    private $usermodel;
    public function index()
    {
        require_once __DIR__ . '/../Views/loginform.php';
    }

    public function login(User $usermodel)
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
    }
}