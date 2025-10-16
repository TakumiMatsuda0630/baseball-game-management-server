<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\Entity;

use Application\Domain\Stadium\ValueObject\StadiumId;
use Application\Domain\Stadium\ValueObject\StadiumName;

class Stadium
{
    public function __construct(
        private readonly StadiumId $id, 
        private StadiumName $name
    )
    {}

    public function id(): StadiumId
    {
        return $this->id;
    }

    public function name(): StadiumName
    {
        return $this->name;
    }

    public function setName(StadiumName $stadiumName): void
    {
        $this->name = $stadiumName;
    }

    public function toArray(): array
    {
        return [
            'id' => (string)$this->id(),
            'name' => (string)$this->name(),
        ];
    }
}