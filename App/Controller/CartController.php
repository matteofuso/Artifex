<?php

namespace App\Controller;
require_once 'App/Model/Cart.php';
require_once 'App/Model/User.php';
require_once 'App/Model/Ordine.php';
require_once 'Functions/Log.php';
require_once 'Functions/Panic.php';
use App\Model\Cart;
use App\Model\User;
use Functions\Log;
use App\Model\Ordine;
use Functions\Panic;

class CartController
{
    public function carrello(): void
    {
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 1) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        $cart = new Cart();
        try {
            $cart = $cart->getAll($_SESSION['uid']);
        } catch (\Exception $e) {
            $_GET['err'] = 0;
            Log::write($e);
        }
        require_once 'App/View/carrello/carrello.php';
    }

    public function add(): void
    {
        require_once 'App/Actions/add_cart.php';
    }

    public function checkout(): void
    {
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 1) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        $cart = new Cart();
        try {
            $cart = $cart->getAll($_SESSION['uid']);
        } catch (\Exception $e) {
            $_GET['err'] = 0;
            Log::write($e);
        }
        require_once 'App/View/carrello/checkout.php';
    }

    public function processPayment(): void
    {
        require_once 'App/Actions/process_payment.php';
    }

    public function ordini(): void
    {
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 1) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        $ordine = new Ordine();
        try {
            $ordini = $ordine->getAll($_SESSION['uid']);
        } catch (\Exception $e) {
            $_GET['err'] = 0;
            Log::write($e);
        }
        require_once 'App/View/carrello/ordini.php';
    }

    public function editQuantity(): void
    {
        require_once 'App/Actions/cart_edit_quantity.php';
    }

    public function biglietto(array $args)
    {
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 1) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        try
        {
            $ordine = new Ordine();
            $ordine->get($args[0]);
        } catch (\Exception $e){
            Log::write($e);
        }

        if (($ordine->getIdTurista() ?? 0) != $_SESSION['uid']){
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        try {
            $user = new User();
            $user->get($ordine->getIdTurista());
        } catch (\Exception $e) {
            Log::write($e);
        }

        require_once 'App/View/carrello/biglietto.php';
    }
}