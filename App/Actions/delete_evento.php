<?php
require_once 'Database/Database.php';
require_once 'App/Model/Evento.php';
require_once 'Functions/Panic.php';
require_once 'Functions/Log.php';
require_once 'Config/Project.php';

use App\Model\Evento;
use Database\Database;
use Functions\Panic;
use Functions\Log;
use Config\Project as Config;

$id = $_POST['id'] ?? null;

if (empty($id)) {
    Panic::panic('admin/eventi', 1);
}

try {
    Database::connect();
    $evento = new Evento(id: $id);
    $evento->delete();
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('admin/eventi', 0);
}

header('Location: ' . Config::$path . 'admin/eventi');