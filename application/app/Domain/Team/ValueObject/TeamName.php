<?php

declare(strict_types=1);

namespace Application\Domain\Team\ValueObject;

use InvalidArgumentException;

readonly class TeamName
{
    private const MAX_LENGTH = 100;

    public function __construct(private string $value)
    {
        if ($value === '') {
            throw new InvalidArgumentException('TeamName cannot be empty.');
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('TeamName must be 100 characters or fewer.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
