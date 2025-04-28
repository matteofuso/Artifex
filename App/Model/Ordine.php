<?php

namespace App\Model;
require_once 'Evento.php';

use Database\Database;
use DateTime;

class Ordine
{
    public function __construct(
        private ?int    $id = null,
        private ?int    $id_evento = null,
        private ?int    $id_turista = null,
        private ?int    $quantita = null,
        private ?DateTime $data = null,
        private ?Evento $evento = null,
    )
    {
        Database::connect();
    }

    public function getQuantita(): ?int
    {
        return $this->quantita;
    }

    public function setQuantita(?int $quantita): void
    {
        $this->quantita = $quantita;
    }

    public function getData(): ?DateTime
    {
        return $this->data;
    }

    public function setData(?DateTime $data): void
    {
        $this->data = $data;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): void
    {
        $this->evento = $evento;
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

    public function getIdTurista(): ?int
    {
        return $this->id_turista;
    }

    public function setIdTurista(?int $id_turista): void
    {
        $this->id_turista = $id_turista;
    }

    public function getAll(int $uid): array
    {
        $query = "SELECT * FROM ordini o
         inner join eventi e on o.id_evento = e.eid
         inner join visite v on e.id_visita = v.vid
         where o.id_turista = :uid";
        $result = Database::select($query, [
            'uid' => $uid,
        ]);
        if (empty($result)) {
            return [];
        }
        $carrelli = [];
        foreach ($result as $row) {
            $carrelli[] = new Ordine(
                id: $row['oid'],
                id_evento: $row['id_evento'],
                id_turista: $row['id_turista'],
                quantita: $row['quantita'],
                data: new DateTime($row['data']),
                evento: new Evento(
                    id: $row['eid'],
                    inizio: $row['inizio'],
                    minimoPartecipanti: $row['minimo_partecipanti'],
                    massimoPartecipanti: $row['massimo_partecipanti'],
                    prezzo: $row['prezzo'],
                    visita: new Visita(
                        id: $row['vid'],
                        titolo: $row['titolo'],
                        descrizione: $row['descrizione'],
                        durataMedia: $row['durata_media'],
                    )
                )
            );
        }
        return $carrelli;
    }

    public function transfer(int $uid)
    {
        $query = "insert into ordini(id_evento, id_turista, data, quantita)
            select id_evento, id_turista, now(), c.quantita from carrello c
            where c.id_turista = :uid;";
        Database::execute($query, [
            'uid' => $uid,
        ]);
    }
}