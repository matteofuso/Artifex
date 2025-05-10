<?php

namespace App\Controller;

use Functions\Panic;

class GuideController
{
    public function create(): void{
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        require_once 'App/Actions/add_guide.php';
    }

    public function update(): void{
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        require_once 'App/Actions/edit_guide.php';
    }

    public function delete(): void{
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        require_once 'App/Actions/delete_guide.php';
    }
}