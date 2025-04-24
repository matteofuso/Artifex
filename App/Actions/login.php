<?php
require 'App\Model\User.php';
require_once 'Functions/Log.php';

use App\Model\User;
use Functions\Log;
use Functions\Session;
use Functions\Panic;
use Config\Project as Config;

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$referer = urldecode($_POST['referer']) ?? Config::$path;
$remember = $_POST['remember'] ?? null;

if (empty($email) || empty($password)) {
    Panic::panic('account/login', 1, $referer);
}

$user = new User();
try {
    $user->get($email);
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('account/login', 0, $referer);
}

if (empty($user->getEmail()) || !password_verify($password, $user->getPassword())) {
    Panic::panic('account/login', 2, $referer);
}

Session::start();
if ($remember) {
    Session::extend();
}
Session::store($user->getId(), $user->getTipologia()->getId(), $user->getNome());
header('Location: ' . $referer);