<?php
require_once 'App\Model\User.php';
require_once 'Functions/Log.php';
use App\Model\User;
use App\Model\Lingua;
use Functions\Log;
use Functions\Panic;
use Config\Project as Config;

$id = $_SESSION['uid'] ?? null;
$nome = $_POST['nome'] ?? null;
$cognome = $_POST['cognome'] ?? null;
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$lingua = $_POST['lingua'] ?? null;
$current_password = $_POST['current_password'] ?? null;
$new_password = $_POST['new_password'] ?? null;
$new_password_confirm = $_POST['confirm_password'] ?? null;

$password = empty($new_password) ? null : $new_password;
$telefono = empty($telefono) ? null : $telefono;

if (empty($id) || empty($nome) || empty($cognome) || empty($email) || empty($lingua)) {
    Panic::panic('account/show', 1);
    exit;
}

if (!empty($current_password)) {
    if ($new_password !== $new_password_confirm) {
        Panic::panic('account/show', 6);
        exit;
    }
    $user = new User();
    try {
        $user->get(id: $id);
    } catch (Exception $e) {
        Log::write($e);
        Panic::panic('account/show', 0);
        exit;
    }
    if (password_verify($current_password, $user->getPassword())) {
        $password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
        Panic::panic('account/show', 2);
        exit;
    }
}

$user = new User(
    id: $id,
    email: $email,
    nome: $nome,
    cognome: $cognome,
    password: $password,
    telefono: $telefono,
    lingua: new Lingua(
        id: $lingua,
    )
);

try {
    $user->update($user);
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('account/show', 0);
    exit;
}

$_SESSION['nome'] = $user->getNome();
header('Location: ' . Config::$path . 'account/show');