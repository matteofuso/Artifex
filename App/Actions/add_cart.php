<?php
use App\Model\Cart;
use Functions\Session;
use Functions\Panic;
use Config\Project as Config;

require_once 'Functions/Session.php';
require_once 'Functions/Panic.php';
require_once 'Config/Project.php';

Session::start();
$eid = $_POST['id'] ?? null;
$uid = $_SESSION['uid'] ?? null;
$quantita = $_POST['quantita'] ?? null;

if (empty($eid) || empty($uid) || empty($quantita)) {
    Panic::panic('carrello', 1);
}

$cart = new Cart();
try {
    $cart->add(new Cart(
        id_evento: $eid,
        id_turista: $uid,
        quantita: $quantita,
    ));
} catch (Exception $e) {
    Panic::panic('carrello', 0);
}

header('Location: ' . Config::$path . 'carrello');