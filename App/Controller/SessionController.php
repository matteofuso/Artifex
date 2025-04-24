<?php

namespace App\Controller;
use Functions\Panic;

require 'Functions/Panic.php';

class SessionController
{
    public function login()
    {
        require 'App/Actions/login.php';
    }

    public function logout()
    {
        require 'App/Actions/logout.php';
    }

    public function register()
    {
        require 'App/Actions/register.php';
    }

    public function update()
    {
        if (!isset($_SESSION['uid'])) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        require 'App/Actions/update_account.php';
    }
}