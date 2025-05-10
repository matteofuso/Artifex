<?php
require_once 'Database/Database.php';
require_once 'App/Model/Guida.php';
require_once 'Functions/Panic.php';
require_once 'Functions/Log.php';
require_once 'Config/Project.php';

use App\Model\Guida;
use App\Model\TitoloStudio;
use Database\Database;
use Functions\Panic;
use Functions\Log;
use Config\Project as Config;

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? null;
$cognome = $_POST['cognome'] ?? null;
$luogo_nascita = $_POST['luogo_nascita'] ?? null;
$data_nascita = $_POST['data_nascita'] ?? null;
$titolo_studio = $_POST['titolo_studio'] ?? null;

if (empty($id) || empty($nome) || empty($cognome) || empty($luogo_nascita) || empty($data_nascita) || empty($titolo_studio)) {
    Panic::panic('admin/guide', 1);
}

try {
    Database::connect();
    $guida = new Guida(
        id: $id,
        nome: $nome,
        cognome: $cognome,
        luogo_nascita: $luogo_nascita,
        data_nascita: new DateTime($data_nascita),
        titolo_studio: new TitoloStudio(
            id: $titolo_studio
        )
    );
    $guida->update();
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('admin/guide', 0);
}

header('Location: ' . Config::$path . 'admin/guide');