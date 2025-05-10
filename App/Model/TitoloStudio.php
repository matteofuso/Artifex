<?php

namespace App\Model;
require_once 'ModelInterface.php';

use Database\Database;
use DateTime;

class TitoloStudio implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $nome = null,
    )
    {
        Database::connect();
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function get(int $id): void{
        $query = "SELECT * FROM titoli_studio WHERE tsid = :id";
        $binds = [':id' => $id];
        $result = Database::select($query, $binds);
        if (count($result) > 0) {
            $this->id = $result[0]['id'];
            $this->nome = $result[0]['nome'];
        }
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM titoli_studio";
        $result = Database::select($query);
        $titoli = [];
        foreach ($result as $row) {
            $titolo = new TitoloStudio();
            $titolo->setId($row['tsid']);
            $titolo->setNome($row['titolo']);
            $titoli[] = $titolo;
        }
        return $titoli;
    }
}