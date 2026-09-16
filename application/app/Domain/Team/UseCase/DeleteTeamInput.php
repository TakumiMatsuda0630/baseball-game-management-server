<?php

declare(strict_types=1);

namespace Application\Domain\Team\UseCase;

readonly class DeleteTeamInput
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
