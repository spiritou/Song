<?php
namespace App\core;

class Auth
{
    public static function requireLogin()
    {
        if(!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }

    public static function requireRole($role)
    {
        self::requireLogin();
        if($_SESSION['user_role'] !== $role) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }
    }
}