<?php

namespace App\Controller;
require_once 'App/Model/Cart.php';
require_once 'App/Model/Ordine.php';
require_once 'Functions/Log.php';
use App\Model\Cart;
use Functions\Log;
use App\Model\Ordine;

class CartController
{
    public function carrello(): void
    {
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
        $ordine = new Ordine();
        try {
            $ordini = $ordine->getAll($_SESSION['uid']);
        } catch (\Exception $e) {
            $_GET['err'] = 0;
            Log::write($e);
        }
        require_once 'App/View/carrello/ordini.php';
    }
}