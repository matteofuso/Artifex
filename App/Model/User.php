<?php

namespace App\Model;
require 'ModelInterface.php';
require_once 'Lingua.php';
require_once 'TipologiaAccount.php';

use Database\Database;

class User implements ModelInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $email = null,
        private ?string $nome = null,
        private ?string $cognome = null,
        private ?string $password = null,
        private ?string $telefono = null,
        private ?TipologiaAccount $tipologia = null,
        private ?Lingua $lingua = null,
    )
    {
        Database::connect();
    }

    public function getTipologia(): ?TipologiaAccount
    {
        return $this->tipologia;
    }

    public function setTipologia(?TipologiaAccount $tipologia): void
    {
        $this->tipologia = $tipologia;
    }

    public function getLingua(): ?Lingua
    {
        return $this->lingua;
    }

    public function setLingua(?Lingua $lingua): void
    {
        $this->lingua = $lingua;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function get(string|int $id = null): void
    {
        $result = Database::select('
                select * from account a
                inner join tipologia_account ta on ta.tid = a.id_tipologia
                inner join lingue l on l.lid = a.id_lingua
                where a.email = :email or a.aid = :id;', [
            ':email' => $id,
            ':id' => $id,
        ]);
        if (count($result) > 0) {
            $this->id = $result[0]['aid'];
            $this->email = $result[0]['email'];
            $this->nome = $result[0]['nome'];
            $this->cognome = $result[0]['cognome'];
            $this->password = $result[0]['password'];
            $this->telefono = $result[0]['telefono'];
            $this->tipologia = new TipologiaAccount(
                id: $result[0]['id_tipologia'],
                tipologia: $result[0]['tipologia']
            );
            $this->lingua = new Lingua(
                id: $result[0]['id_lingua'],
                lingua: $result[0]['lingua']
            );
        }
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM account a
                INNER JOIN tipologia_account ta ON ta.tid = a.id_tipologia
                INNER JOIN lingue l ON l.lid = a.id_lingua';
        $result = Database::select($query);
        $users = [];
        foreach ($result as $row) {
            $users[] = new User(
                id: $row['aid'],
                email: $row['email'],
                nome: $row['nome'],
                cognome: $row['cognome'],
                password: $row['password'],
                telefono: $row['telefono'],
                tipologia: new TipologiaAccount(
                    id: $row['id_tipologia'],
                    tipologia: $row['tipologia']
                ),
                lingua: new Lingua(
                    id: $row['id_lingua'],
                    lingua: $row['lingua']
                )
            );
        }
        return $users;
    }

    public function create(User $user): void
    {
        $query = 'INSERT INTO account (nome, cognome, email, password, telefono, id_tipologia, id_lingua) VALUES (:nome, :cognome, :email, :password, :telefono, :id_tipologia, :id_lingua)';
        $params = [
            ':nome' => $user->nome,
            ':cognome' => $user->cognome,
            ':email' => $user->email,
            ':password' => $user->password,
            ':telefono' => $user->telefono,
            ':id_tipologia' => $user->tipologia->getId(),
            ':id_lingua' => $user->lingua->getId(),
        ];
        Database::execute($query, $params);
    }

    public function update(User $user): void
    {
        $query = 'UPDATE account SET nome = :nome, cognome = :cognome, email = :email, id_lingua = :id_lingua';
        $params = [
            ':id' => $this->id,
            ':nome' => $user->nome,
            ':cognome' => $user->cognome,
            ':email' => $user->email,
            ':id_lingua' => $user->lingua->getId(),
        ];
        if (!is_null($user->tipologia)) {
            $query .= ', id_tipologia = :id_tipologia';
            $params[':id_tipologia'] = $user->tipologia->getId();
        }
        if (!is_null($user->password)) {
            $query .= ', password = :password';
            $params[':password'] = $user->password;
        }
        if (!is_null($user->telefono)) {
            $query .= ', telefono = :telefono';
            $params[':telefono'] = $user->telefono;
        }
        $query .= ' WHERE aid = :id';
        Database::execute($query, $params);
    }
}