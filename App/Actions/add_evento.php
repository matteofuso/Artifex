<?php
require_once 'Database/Database.php';
require_once 'App/Model/Evento.php';
require_once 'Functions/Panic.php';
require_once 'Functions/Log.php';
require_once 'Config/Project.php';

use App\Model\Evento;
use App\Model\Visita;
use Database\Database;
use Functions\Panic;
use Functions\Log;
use Config\Project as Config;

$inizio = $_POST['inizio'] ?? null;
$id_visita = $_POST['id_visita'] ?? null;
$minimo_partecipanti = $_POST['minimo_partecipanti'] ?? null;
$massimo_partecipanti = $_POST['massimo_partecipanti'] ?? null;
$prezzo = $_POST['prezzo'] ?? null;

if (empty($inizio) || empty($id_visita) || empty($minimo_partecipanti) || empty($massimo_partecipanti) || empty($prezzo)) {
    Panic::panic('admin/eventi', 1);
}

try {
    Database::connect();
    $evento = new Evento(
        inizio: $inizio,
        minimoPartecipanti: $minimo_partecipanti,
        massimoPartecipanti: $massimo_partecipanti,
        prezzo: $prezzo,
        visita: new Visita(
            id: $id_visita
        )
    );
    $evento->create();
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('admin/eventi', 0);
}

header('Location: ' . Config::$path . 'admin/eventi');