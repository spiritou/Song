<?php

namespace App\Core;

use App\Models\Song;

class Songcontroller 
{
    private $songModel;

    public function __construct(Song $songModel)
    {
        $this->songModel = $songModel;
    }
    
}