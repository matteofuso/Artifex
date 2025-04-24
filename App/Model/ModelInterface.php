<?php

namespace App\Model;
require_once 'Database/Database.php';

interface ModelInterface
{
    public function getAll(): array;
    public function get(int $id): void;
}