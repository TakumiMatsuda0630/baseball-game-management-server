<?php

declare(strict_types=1);

namespace Application\Domain\Team\UseCase;

readonly class StoreTeamInput
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
