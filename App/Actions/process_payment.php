<?php

require_once 'App/Model/Ordine.php';
require_once 'App/Model/Cart.php';
require_once 'Config/Project.php';
require_once 'Functions/Log.php';
use App\Model\Ordine;
use App\Model\Cart;
use Config\Project as Config;
use Functions\Log;

$uid = $_SESSION['uid'] ?? null;

if ($uid === null) {
    header('Location: /login');
    exit;
}

$cart = new Cart();
$order = new Ordine();

try {
    $order->transfer($uid);
    $cart->empty($uid);
} catch (Exception $e) {
    header('Location: ' . Config::$path . 'carrello?err=0');
    Log::write($e);
    die;
}

header('Location: ' . Config::$path . 'account/ordini');
