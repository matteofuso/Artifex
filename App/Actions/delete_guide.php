<?php
require_once 'Database/Database.php';
require_once 'App/Model/Guida.php';
require_once 'Functions/Panic.php';
require_once 'Functions/Log.php';
require_once 'Config/Project.php';

use App\Model\Guida;
use Database\Database;
use Functions\Panic;
use Functions\Log;
use Config\Project as Config;

$id = $_POST['id'] ?? null;

if (empty($id)) {
    Panic::panic('admin/guide', 1);
}

try {
    Database::connect();
    $evento = new Guida(id: $id);
    $evento->delete();
} catch (Exception $e) {
    Log::write($e);
    Panic::panic('admin/guide', 0);
}

header('Location: ' . Config::$path . 'admin/guide');