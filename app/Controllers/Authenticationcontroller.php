<?php

namespace App\Controllers;

class Authenticationcontroller 
{
    public function login()
    {
        require_once __DIR__ . '/../Views/loginform.php';
    }
}