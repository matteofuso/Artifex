<?php
namespace App\Controller;
require_once 'App/Model/User.php';
require_once 'App/Model/Lingua.php';
require_once 'Config/Log.php';
require_once 'Functions/Panic.php';

use App\Model\Lingua;
use App\Model\User;
use Functions\Log;
use Functions\Panic;

class AccountController
{
    public function register(): void
    {
        $lingua = new Lingua();
        try {
            $lingue = $lingua->getAll();
        } catch (\Exception $e) {
            Log::write($e);
            $_GET['err'] = 0;
        }
        require_once 'App/View/account/register.php';
    }

    public function login(): void
    {
        require_once 'App/View/account/login.php';
    }

    public function show(): void {
        if (!isset($_SESSION['uid'])) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        $user = new User();
        $lingua = new Lingua();
        try {
            $user->get($_SESSION['uid']);
            $lingue = $lingua->getAll();
        } catch (\Exception $e) {
            Log::write($e);
            $_GET['err'] = 0;
        }
        require_once 'App/View/account/account.php';
    }
}