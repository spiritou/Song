<?php

namespace App\Controllers;

use App\Models\Song;

class Songcontroller 
{
    private $songModel;

    // public function __construct(Song $songModel)
    // {
    //     $this->songModel = $songModel;
    // }

    public function index()
    {
        echo "This is the index method of Songcontroller.";
        // You can add more logic here to interact with the model and view
    }
    
}