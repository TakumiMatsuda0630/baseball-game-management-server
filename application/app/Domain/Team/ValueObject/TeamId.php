<?php

declare(strict_types=1);

namespace Application\Domain\Team\ValueObject;

use InvalidArgumentException;

readonly class TeamId
{
    public function __construct(private string $value)
    {
        if (preg_match('/\A[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}\z/iD', $value) !== 1) {
            throw new InvalidArgumentException('TeamId must be a valid UUID.');
        }
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
