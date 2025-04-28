<?php

namespace App\Model;
require_once 'Evento.php';

use Database\Database;

class Cart
{
    public function __construct(
        private ?int    $id = null,
        private ?int    $id_evento = null,
        private ?int    $id_turista = null,
        private ?int    $quantita = null,
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
        $query = "SELECT * FROM carrello c
         inner join eventi e on c.id_evento = e.eid
         inner join visite v on e.id_visita = v.vid
         where c.id_turista = :uid";
        $result = Database::select($query, [
            'uid' => $uid,
        ]);
        if (empty($result)) {
            return [];
        }
        $carrelli = [];
        foreach ($result as $row) {
            $carrelli[] = new Cart(
                id: $row['cid'],
                id_evento: $row['id_evento'],
                id_turista: $row['id_turista'],
                quantita: $row['quantita'],
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

    public function add(Cart $carrello): void
    {
        # check if the event is already in the cart
        $query = "SELECT * FROM carrello WHERE id_evento = :id_evento AND id_turista = :id_turista";
        $result = Database::select($query, [
            'id_evento' => $carrello->getIdEvento(),
            'id_turista' => $carrello->getIdTurista(),
        ]);
        if (!empty($result)) {
            # if the event is already in the cart, update the quantity
            $query = "UPDATE carrello SET quantita = quantita + :quantita WHERE id_evento = :id_evento AND id_turista = :id_turista";
            Database::execute($query, [
                'id_evento' => $carrello->getIdEvento(),
                'id_turista' => $carrello->getIdTurista(),
                'quantita' => $carrello->getQuantita(),
            ]);
            return;
        }
        $query = "INSERT INTO carrello (id_evento, id_turista, quantita) VALUES (:id_evento, :id_turista, :quantita)";
        Database::execute($query, [
            'id_evento' => $carrello->getIdEvento(),
            'id_turista' => $carrello->getIdTurista(),
            'quantita' => $carrello->getQuantita(),
        ]);
    }

    public function empty(int $uid): void
    {
        $query = "DELETE FROM carrello WHERE id_turista = :uid";
        Database::execute($query, [
            'uid' => $uid,
        ]);
    }

    public function editQuantity(int $id, int $incremento)
    {
        $query = "UPDATE carrello SET quantita = quantita + :incremento WHERE cid = :id";
        Database::execute($query, [
            'incremento' => $incremento,
            'id' => $id,
        ]);
        $query = "SELECT quantita FROM carrello WHERE cid = :id";
        $result = Database::select($query, [
            'id' => $id,
        ]);
        if ($result[0]['quantita'] <= 0) {
            $query = "DELETE FROM carrello WHERE cid = :id";
            Database::execute($query, [
                'id' => $id,
            ]);
        }
    }
}