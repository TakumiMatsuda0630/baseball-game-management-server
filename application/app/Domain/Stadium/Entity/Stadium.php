<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\Entity;

use Application\Domain\Stadium\ValueObject\StadiumId;
use Application\Domain\Stadium\ValueObject\StadiumName;

readonly class Stadium
{
    public function __construct(
        private StadiumId $id, 
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

    public function toArray(): array
    {
        return [
            'id' => (string)$this->id(),
            'name' => (string)$this->name(),
        ];
    }
}