<?php

namespace App\Model;
require_once 'ModelInterface.php';
require_once 'TitoloStudio.php';
use DateTime;
use Database\Database;
class Guida implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $nome = null,
        private ?string $cognome = null,
        private ?string $luogo_nascita = null,
        private ?DateTime $data_nascita = null,
        private ?TitoloStudio $titolo_studio = null,
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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(?string $cognome): void
    {
        $this->cognome = $cognome;
    }

    public function getLuogoNascita(): ?string
    {
        return $this->luogo_nascita;
    }

    public function setLuogoNascita(?string $luogo_nascita): void
    {
        $this->luogo_nascita = $luogo_nascita;
    }

    public function getDataNascita(): ?DateTime
    {
        return $this->data_nascita;
    }

    public function setDataNascita(?DateTime $data_nascita): void
    {
        $this->data_nascita = $data_nascita;
    }

    public function getTitoloStudio(): ?TitoloStudio
    {
        return $this->titolo_studio;
    }

    public function setTitoloStudio(?TitoloStudio $titolo_studio): void
    {
        $this->titolo_studio = $titolo_studio;
    }

    public function get(int $id): void
    {
        $query = "SELECT * FROM guide g
         inner join titoli_studio ts on g.titolo_studio = ts.tsid
         WHERE gid = :id";
        $result = Database::select($query, [':id' => $id]);
        if (count($result) > 0){
            $this->id = $result[0]['gid'];
            $this->nome = $result[0]['nome'];
            $this->cognome = $result[0]['cognome'];
            $this->luogo_nascita = $result[0]['luogo_nascita'];
            $this->data_nascita = new DateTime($result[0]['data_nascita']);
            $this->titolo_studio = new TitoloStudio(
                $result[0]['tsid'],
                $result[0]['nome']
            );
        }
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM guide g
            inner join titoli_studio ts on g.id_titolo_studio = ts.tsid";
        $result = Database::select($query);
        $guide = [];
        foreach ($result as $row) {
            $guida = new Guida();
            $guida->setId($row['gid']);
            $guida->setNome($row['nome']);
            $guida->setCognome($row['cognome']);
            $guida->setLuogoNascita($row['luogo_nascita']);
            $guida->setDataNascita(new DateTime($row['data_nascita']));
            $guida->setTitoloStudio(new TitoloStudio(
                $row['tsid'],
                $row['titolo']
            ));
            $guide[] = $guida;
        }
        return $guide;
    }

    public function create(){
        Database::execute('INSERT INTO guide (nome, cognome, luogo_nascita, data_nascita, id_titolo_studio) values (:nome, :cognome, :luogo_nascita, :data_nascita, :id_titolo_studio);', [
            ':nome' => $this->nome,
            ':cognome' => $this->cognome,
            ':luogo_nascita' => $this->luogo_nascita,
            ':data_nascita' => $this->data_nascita->format('Y-m-d'),
            ':id_titolo_studio' => $this->titolo_studio->getId()
        ]);
    }

    public function update(){
        Database::execute('UPDATE guide SET nome = :nome, cognome = :cognome, luogo_nascita = :luogo_nascita, data_nascita = :data_nascita, id_titolo_studio = :id_titolo_studio WHERE gid = :id;', [
            ':nome' => $this->nome,
            ':cognome' => $this->cognome,
            ':luogo_nascita' => $this->luogo_nascita,
            ':data_nascita' => $this->data_nascita->format('Y-m-d'),
            ':id_titolo_studio' => $this->titolo_studio->getId(),
            ':id' => $this->id
        ]);
    }

    public function delete(): void
    {
        Database::execute('DELETE FROM guide WHERE gid = :id', [':id' => $this->id]);
    }
}