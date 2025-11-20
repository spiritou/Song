<?php 

namespace App\Controllers;
use App\Models\User;

class Usercontroller
{
    private $usermodel;

    public function __construct(User $usermodel)
    {
       $this->usermodel = $usermodel;
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;
        $role = $data['role'] ?? 'user';

        if (trim($username) === '' || trim($password) === '') {
            http_response_code(400);
            echo json_encode (['error' => 'Username and password are required']);
            return;
        }

        $existingUser = $this->usermodel->findByUsername($username);
        if ($existingUser) {
            http_response_code(400);
            echo json_encode (['error' => 'Username already exists']);
            return;
        }

        $created = $this->usermodel->create($username, $password, $role);
        if ($created) {
            http_response_code(201);
            echo json_encode (['message' => 'User registered successfully']);
        } else {
            http_response_code(500);
            echo json_encode (['error' => 'Failed to register user']);
        }
        

    }
}