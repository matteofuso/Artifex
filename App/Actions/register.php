<?php
require 'App\Model\User.php';
require_once 'Functions/Log.php';

use App\Model\User;
use App\Model\Lingua;
use Functions\Log;
use Functions\Panic;
use Config\Project as Config;

$nome = $_POST['nome'] ?? null;
$cognome = $_POST['cognome'] ?? null;
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$lingua = $_POST['lingua'] ?? null;
$password = $_POST['password'] ?? null;
$confirm_password = $_POST['confirm_password'] ?? null;
$referer = urldecode($_POST['referer']) ?? Config::$path;

if (empty($nome) || empty($cognome) || empty($email) || empty($password) || empty($confirm_password) || empty($lingua) || empty($telefono)) {
    Panic::panic('account/register', 1, $referer);
}

if ($password !== $confirm_password) {
    Panic::panic('account/register', 3, $referer);
}

$user = new User();
try {
    $user->get($email);
    if ($user->getId() !== null) {
        Panic::panic('account/register', 4, $referer);
    }
    $user->create(new User(
        email: $email,
        nome: $nome,
        cognome: $cognome,
        password: password_hash($password, PASSWORD_DEFAULT),
        telefono: $telefono,
        lingua: new Lingua(
            id: $lingua,
        )
    ));
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('account/register', 0, $referer);
}
header('Location: ' . Config::$path . 'account/login?ref=' . urlencode($referer));