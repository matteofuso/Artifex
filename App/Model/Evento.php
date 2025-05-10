<?php

namespace App\Model;
require_once 'Visita.php';

use DateTime;
use Database\Database;

class Evento implements ModelInterface
{
    private ?DateTime $inizio = null;
    public function __construct(
        private ?int $id = null,
        ?string $inizio = null,
        private ?int $minimoPartecipanti = null,
        private ?int $massimoPartecipanti = null,
        private ?float $prezzo = null,
        private ?Visita $visita = null,
    ){
        Database::connect();
        $this->inizio = new DateTime($inizio);
    }

    public function getVisita(): ?Visita
    {
        return $this->visita;
    }

    public function setVisita(?Visita $visita): void
    {
        $this->visita = $visita;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getInizio(): ?DateTime
    {
        return $this->inizio;
    }

    public function setInizio(?DateTime $inizio): void
    {
        $this->inizio = $inizio;
    }

    public function getMinimoPartecipanti(): ?int
    {
        return $this->minimoPartecipanti;
    }

    public function setMinimoPartecipanti(?int $minimoPartecipanti): void
    {
        $this->minimoPartecipanti = $minimoPartecipanti;
    }

    public function getMassimoPartecipanti(): ?int
    {
        return $this->massimoPartecipanti;
    }

    public function setMassimoPartecipanti(?int $massimoPartecipanti): void
    {
        $this->massimoPartecipanti = $massimoPartecipanti;
    }

    public function getPrezzo(): ?float
    {
        return $this->prezzo;
    }

    public function setPrezzo(?float $prezzo): void
    {
        $this->prezzo = $prezzo;
    }

    public function get(int $id): void
    {
        $query = "select * from eventi e
            inner join visite v on v.vid = e.id_visita
            where eid = :id;";
        $result = Database::select($query, [":id" => $id]);
        if (count($result) == 0) {
            return;
        }
        $this->id = $result[0]["eid"];
        $this->inizio = new DateTime($result[0]["inizio"]);
        $this->minimoPartecipanti = $result[0]["minimo_partecipanti"];
        $this->massimoPartecipanti = $result[0]["massimo_partecipanti"];
        $this->prezzo = $result[0]["prezzo"];
        $this->visita = new Visita(
            id: $result[0]["vid"],
            titolo: $result[0]["titolo"],
            descrizione: $result[0]["descrizione"],
            durataMedia: $result[0]["durata_media"]
        );
    }

    public function getAll(): array
    {
        $query = "select * from eventi e
            inner join visite v on v.vid = e.id_visita
            order by e.inizio;";
        $result = Database::select($query);
        $eventi = [];
        foreach ($result as $row) {
            $eventi[] = new Evento(
                id: $row["eid"],
                inizio: $row["inizio"],
                minimoPartecipanti: $row["minimo_partecipanti"],
                massimoPartecipanti: $row["massimo_partecipanti"],
                prezzo: $row["prezzo"],
                visita: new Visita(
                    id: $row["vid"],
                    titolo: $row["titolo"],
                    descrizione: $row["descrizione"],
                    durataMedia: $row["durata_media"]
                )
            );
        }
        return $eventi;
    }

    public function create(){
        Database::execute('insert into eventi (inizio, minimo_partecipanti, massimo_partecipanti, prezzo, id_visita) 
            values (:inizio, :minimo_partecipanti, :massimo_partecipanti, :prezzo, :id_visita);', [
            ":inizio" => $this->inizio->format("Y-m-d H:i:s"),
            ":minimo_partecipanti" => $this->minimoPartecipanti,
            ":massimo_partecipanti" => $this->massimoPartecipanti,
            ":prezzo" => $this->prezzo,
            ":id_visita" => $this->visita->getId()
        ]);
    }

    public function update(): void
    {
        Database::execute('update eventi set inizio = :inizio, minimo_partecipanti = :minimo_partecipanti, massimo_partecipanti = :massimo_partecipanti, prezzo = :prezzo, id_visita = :id_visita where eid = :id;', [
            ":inizio" => $this->inizio->format("Y-m-d H:i:s"),
            ":minimo_partecipanti" => $this->minimoPartecipanti,
            ":massimo_partecipanti" => $this->massimoPartecipanti,
            ":prezzo" => $this->prezzo,
            ":id_visita" => $this->visita->getId(),
            ":id" => $this->id
        ]);
    }

    public function delete(): void
    {
        Database::execute('delete from eventi where eid = :id;', [
            ":id" => $this->id
        ]);
    }
}