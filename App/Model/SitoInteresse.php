<?php

namespace App\Model;
require_once 'ModelInterface.php';

use Database\Database;

class SitoInteresse implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $nome = null,
        private ?string $luogo = null,
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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getLuogo(): ?string
    {
        return $this->luogo;
    }

    public function setLuogo(?string $luogo): void
    {
        $this->luogo = $luogo;
    }

    public function get(int $id): void
    {
        $query = "SELECT * FROM siti_interesse where sid = :id";
        $result = Database::select($query);
        if (empty($result)) {
            return;
        }
        $this->id = $result[0]['sid'];
        $this->nome = $result[0]['nome'];
        $this->luogo = $result[0]['luogo'];
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM lingue";
        $result = Database::select($query);
        $siti = [];
        foreach ($result as $row) {
            $siti[] = new SitoInteresse(
                id: $row['sid'],
                nome: $row['nome'],
                luogo: $row['luogo']
            );
        }
        return $siti;
    }

    public function getAllFromVisita(int $id): array
    {
        $query = "select si.* from visite v
            inner join visite_siti vs on vs.id_visita = v.vid
            inner join siti_interesse si on vs.id_sito = si.sid
            where v.vid = :id;";
        $result = Database::select($query, [':id' => $id]);
        $siti = [];
        foreach ($result as $row) {
            $siti[] = new SitoInteresse(
                id: $row['sid'],
                nome: $row['nome'],
                luogo: $row['luogo']
            );
        }
        return $siti;
    }
}