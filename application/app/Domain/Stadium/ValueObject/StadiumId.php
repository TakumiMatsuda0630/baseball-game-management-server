<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\ValueObject;

use InvalidArgumentException;

class StadiumId
{
    private const MIN_ID = 1;

    private const MAX_ID = 99999999999;

    private int $id;

    public function __construct(int $id)
    {
        if ($id < self::MIN_ID || $id > self::MAX_ID) {
            throw new InvalidArgumentException('StadiumId must be an 11-digit number.');
        }
        $this->id = $id;
    }

    public function toInt(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }
}
