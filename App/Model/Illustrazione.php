<?php

namespace App\Model;
require_once 'ModelInterface.php';
require_once 'Guida.php';
require_once 'Lingua.php';

use Database\Database;
use DateTime;

class Illustrazione implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?int $id_evento = null,
        private ?Guida $guida = null,
        private ?Lingua $lingua = null,
    )
    {
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

    public function getIdEvento(): ?int
    {
        return $this->id_evento;
    }

    public function setIdEvento(?int $id_evento): void
    {
        $this->id_evento = $id_evento;
    }

    public function getGuida(): ?Guida
    {
        return $this->guida;
    }

    public function setGuida(?Guida $guida): void
    {
        $this->guida = $guida;
    }

    public function getLingua(): ?Lingua
    {
        return $this->lingua;
    }

    public function setLingua(?Lingua $lingua): void
    {
        $this->lingua = $lingua;
    }

    public function get(int $id): void
    {
        $query = "SELECT * FROM illustrazioni i
         inner join guide g on i.id_guida = g.gid
         inner join lingue l on i.id_lingua = l.lid
         WHERE i.iid = :id";
        $result = Database::select($query, [':id' => $id]);
        if (count($result) > 0){
            $this->id = $result[0]['iid'];
            $this->id_evento = $result[0]['id_evento'];
            $this->guida = new Guida(
                $result[0]['gid'],
                $result[0]['nome'],
                $result[0]['cognome'],
                $result[0]['luogo_nascita'],
                new DateTime($result[0]['data_nascita'])
            );
            $this->lingua = new Lingua(
                $result[0]['lid'],
                $result[0]['lingua']
            );
        }
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM illustrazioni i
         inner join guide g on i.id_guida = g.gid
         inner join lingue l on i.id_lingua = l.lid";
        $result = Database::select($query);
        $illustrazioni = [];
        foreach ($result as $row) {
            $illustrazione = new Illustrazione();
            $illustrazione->setId($row['iid']);
            $illustrazione->setIdEvento($row['id_evento']);
            $illustrazione->setGuida(new Guida(
                $row['gid'],
                $row['nome'],
                $row['cognome'],
                $row['luogo_nascita'],
                new DateTime($row['data_nascita'])
            ));
            $illustrazione->setLingua(new Lingua(
                $row['lid'],
                $row['lingua']
            ));
            $illustrazioni[] = $illustrazione;
        }
        return $illustrazioni;
    }
}