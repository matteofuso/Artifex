<?php

namespace App\Model;
require_once 'ModelInterface.php';

use Database\Database;

class TipologiaAccount implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $tipologia = null,
    ) {
        Database::connect();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTipologia(): ?string
    {
        return $this->tipologia;
    }

    public function setTipologia(?string $tipologia): void
    {
        $this->tipologia = $tipologia;
    }

    public function get(int $id): void
    {
        $query = "SELECT * FROM tipologie_account t WHERE t.tid = :id";
        $result = Database::select($query, [':id' => $id]);
        if (empty($result)) {
            return;
        }
        $this->id = $result[0]['id_tipologia'];
        $this->tipologia = $result[0]['tipologia'];
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM tipologie_account";
        $result = Database::select($query);
        $tipologie = [];
        foreach ($result as $row) {
            $tipologie[] = new TipologiaAccount(
                id: $row['id_tipologia'],
                tipologia: $row['tipologia']
            );
        }
        return $tipologie;
    }
}