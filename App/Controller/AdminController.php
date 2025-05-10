<?php

namespace App\Controller;
require_once 'Config/Project.php';
require_once 'Functions/Panic.php';
require_once 'Functions/Log.php';
require_once 'App/Model/Evento.php';
require_once 'App/Model/Visita.php';
require_once 'App/Model/Guida.php';
require_once 'App/Model/TitoloStudio.php';
use Config\Project;
use Functions\Panic;
use Functions\Log;
use App\Model\Evento;
use App\Model\Visita;
use App\Model\Guida;
use App\Model\TitoloStudio;
use Exception;

class AdminController
{
    public static function redirect(){
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        header('Location: ' . Project::$path . 'admin/eventi');
    }

    public static function eventi(){
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        try {
            $eventi = (new Evento())->getAll();
            $visite = (new Visita())->getAll();
        } catch (Exception $e){
            Log::write($e);
        }
        require_once 'App/View/admin/eventi.php';
    }

    public static function guide(){
        $uid = $_SESSION['tid'] ?? 0;
        if ($uid < 2) {
            Panic::panic('account/login', 5, urlencode($_SERVER['REQUEST_URI']));
        }
        try {
            $guide = (new Guida())->getAll();
            $titoliStudio = (new TitoloStudio())->getAll();
        } catch (Exception $e){
            Log::write($e);
        }
        require_once 'App/View/admin/guide.php';
    }
}