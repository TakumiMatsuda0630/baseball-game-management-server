<?php

declare(strict_types=1);

namespace Application\Domain\Stadium\ValueObject;

use InvalidArgumentException;

readonly class StadiumName
{
    private const MAX_LENGTH = 255;

    private string $name;

    public function __construct(string $value)
    {
        if ($value === '') {
            throw new InvalidArgumentException('StadiumName cannot be empty.');
        }
        
        $length = mb_strlen($value);
        if ($length > self::MAX_LENGTH) {
            throw new InvalidArgumentException('StadiumName must be between 1 and 100 characters long.');
        }
        $this->name = $value;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}