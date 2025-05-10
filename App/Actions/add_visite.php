<?php
require_once 'Database/Database.php';
require_once 'App/Model/Evento.php';
require_once 'Functions/Panic.php';
require_once 'Functions/Log.php';
require_once 'Config/Project.php';

use App\Model\Visita;
use Database\Database;
use Functions\Panic;
use Functions\Log;
use Config\Project as Config;

$titolo = $_POST['titolo'] ?? null;
$descrizione = $_POST['descrizione'] ?? null;
$durata_media = $_POST['durata_media'] ?? null;

if (empty($titolo) || empty($descrizione) || empty($durata_media)) {
    Panic::panic('admin/eventi', 1);
}

try {
    Database::connect();
    $visita = new Visita(
        titolo: $titolo,
        descrizione: $descrizione,
        durataMedia: $durata_media
    );
    $visita->create();
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('admin/eventi', 0);
}

header('Location: ' . Config::$path . 'admin/eventi');