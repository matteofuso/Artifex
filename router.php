<?php
require 'Router/Router.php';
require 'Functions/Session.php';
use Router\Router;
use Router\Route;
use Functions\Session;

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$path = dirname($_SERVER['PHP_SELF']);
$uri = '/' . trim(str_replace($path, '', $uri), '/');

$router = new Router();
$router->add(new Route('/', ['GET'], 'StaticController', 'home'));

$router->add(new Route('/eventi', ['GET'], 'EventsController', 'eventi'));
$router->add(new Route('/evento/([0-9]+)/dettagli', ['GET'], 'EventsController', 'evento'));

$router->add(new Route('/carrello', ['GET'], 'CartController', 'carrello'));
$router->add(new Route('/checkout', ['GET'], 'CartController', 'checkout'));
$router->add(new Route('/action/add_cart', ['POST'], 'CartController', 'add'));
$router->add(new Route('/action/process-payment', ['POST'], 'CartController', 'processPayment'));
$router->add(new Route('/action/cart_edit_quantity', ['POST'], 'CartController', 'editQuantity'));

$router->add(new Route('/admin', ['GET'], 'AdminController', 'redirect'));
$router->add(new Route('/admin/eventi', ['GET'], 'AdminController', 'eventi'));
$router->add(new Route('/admin/guide', ['GET'], 'AdminController', 'guide'));

$router->add(new Route('/account/login', ['GET'], 'AccountController', 'login'));
$router->add(new Route('/account/register', ['GET'], 'AccountController', 'register'));
$router->add(new Route('/account/show', ['GET'], 'AccountController', 'show'));
$router->add(new Route('/account/ordini', ['GET'], 'CartController', 'ordini'));
$router->add(new Route('/ticket/([0-9]+)', ['GET'], 'CartController', 'biglietto'));
$router->add(new Route('/action/login', ['POST'], 'SessionController', 'login'));
$router->add(new Route('/action/logout', ['POST'], 'SessionController', 'logout'));
$router->add(new Route('/action/register', ['POST'], 'SessionController', 'register'));
$router->add(new Route('/action/update_account', ['POST'], 'SessionController', 'update'));


try {
    $route = $router->match($uri, $_SERVER['REQUEST_METHOD']);
    $controllerName = $route['controller'];
    $actionName = $route['action'];
    require_once "App/Controller/$controllerName.php";
    $controllerName = 'App\\Controller\\' . $controllerName;
    $controllerObj = new $controllerName();
    Session::start();
    $controllerObj->$actionName($route['params']);
} catch (Exception $e) {
    if ($e->getMessage() === "404") {
        http_response_code(404);
        require 'App/View/http_errors/404.php';
    } elseif ($e->getMessage() === "405") {
        http_response_code(405);
        require 'App/View/http_errors/405.php';
    } else {
        http_response_code(500);
        require 'App/View/http_errors/500.php';
    }
}