<?php

namespace App\Model;
use Database\Database;

class Lingua implements ModelInterface
{
    public function __construct(
        private ?int $id = 0,
        private ?string $lingua = null,
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

    public function getLingua(): ?string
    {
        return $this->lingua;
    }

    public function setLingua(?string $lingua): void
    {
        $this->lingua = $lingua;
    }

    public function get(int $id): void
    {
        $query = "SELECT * FROM lingue where lid = :id";
        $result = Database::select($query);
        if (empty($result)) {
            return;
        }
        $this->id = $result[0]['lid'];
        $this->lingua = $result[0]['lingua'];
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM lingue";
        $result = Database::select($query);
        $lingue = [];
        foreach ($result as $row) {
            $lingue[] = new Lingua(
                id: $row['lid'],
                lingua: $row['lingua']
            );
        }
        return $lingue;
    }
}