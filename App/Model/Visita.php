<?php

namespace App\Model;
require 'ModelInterface.php';

use Database\Database;

class Visita implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $titolo = null,
        private ?string $descrizione = null,
        private ?int $durataMedia = null,
    ) {
        Database::connect();
    }

    public function getTitolo(): ?string
    {
        return $this->titolo;
    }

    public function setTitolo(?string $titolo): void
    {
        $this->titolo = $titolo;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(?string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    public function getDurataMedia(): ?int
    {
        return $this->durataMedia;
    }

    public function setDurataMedia(?int $durataMedia): void
    {
        $this->durataMedia = $durataMedia;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function get(int $id): void
    {
        $query = "SELECT * FROM visite WHERE vid = :id";
        $result = Database::select($query, [':id' => $id]);
        if (empty($result)) {
            return;
        }
        $this->id = $result[0]['vid'];
        $this->titolo = $result[0]['titolo'];
        $this->descrizione = $result[0]['descrizione'];
        $this->durataMedia = $result[0]['durata_media'];
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM visite";
        $result = Database::select($query);
        $visite = [];
        foreach ($result as $row) {
            $visite[] = new Visita(
                id: $row['id'],
                titolo: $row['titolo'],
                descrizione: $row['descrizione'],
                durataMedia: $row['durata_media']
            );
        }
        return $visite;
    }
}