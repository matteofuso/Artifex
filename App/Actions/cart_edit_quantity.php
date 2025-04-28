<?php
use Functions\Panic;
use App\Model\Cart;
use Config\Project as Config;

require_once 'Config/Project.php';

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;

if (empty($id) || empty($action)) {
    Panic::panic('carrello', 1);
}

$cart = new Cart();
try {
    $cart->editQuantity($id, $action == "increase" ? 1 : -1);
} catch (Exception $e) {
    Panic::panic('carrello', 0);
}

header('Location: ' . Config::$path . 'carrello');