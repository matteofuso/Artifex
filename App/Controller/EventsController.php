<?php

namespace App\Controller;
require 'App/Model/Evento.php';
require 'App/Model/SitoInteresse.php';
require 'App/Model/Illustrazione.php';
require_once 'Config/Log.php';
require_once 'Functions/Panic.php';
use App\Model\Evento;
use App\Model\Illustrazione;
use Functions\Log;
use App\Model\SitoInteresse;
use Functions\Panic;
use Exception;

class EventsController
{
    public function eventi(): void
    {
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 1) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        $evento = new Evento();
        try {
            $eventi = $evento->getAll();
        } catch (\Exception $e) {
            Log::write($e);
            $_GET['err'] = 0;
        }
        require_once 'App/View/eventi/eventi.php';
    }

    public function evento(array $params): void
    {
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 1) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        $evento = new Evento();
        $sito = new SitoInteresse();
        $illustrazione = new Illustrazione();
        try {
            $evento->get($params[0]);
            $siti = is_null($evento->getVisita()) ? [] : $sito->getAllFromVisita($evento->getVisita()->getId());
            $illustrazione->get($evento->getId());
        } catch (Exception $e) {
            Log::write($e);
            $_GET['err'] = 0;
        }
        if (empty($evento->getId())) {
            require_once 'App/View/eventi/error.php';
        } else {
            require_once 'App/View/eventi/evento.php';
        }
    }

    public function create(): void{
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        require_once 'App/Actions/add_evento.php';
    }

    public function update(): void{
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        require_once 'App/Actions/edit_evento.php';
    }

    public function delete(): void{
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }

        require_once 'App/Actions/delete_evento.php';
    }
}