<?php

namespace App\Controller;

class StaticController
{
    public function home(): void
    {
        require_once 'App/View/index.php';
    }

}